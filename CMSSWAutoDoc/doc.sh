#!/bin/bash -x

# get the scram
shopt -s expand_aliases
source /cvmfs/cms.cern.ch/cmsset_default.sh

# if you get negative (!=0) result from the last command,
# print the error message and exit
function checkError(){
    if [ $(echo $?) -ne 0 ]; then
        echo "ERROR: $1"
        exit 1
    fi
}

WORK_DIR=$PWD
echo "workdir: ${WORK_DIR}"
BASE=$(dirname $(readlink -f "${BASH_SOURCE[0]}"))
cd $BASE
TMP="TMP"
mkdir $TMP
TMP="${PWD}/TMP"
ARCH=$ARCHITECTURE
REL=$RELEASE_FORMAT

# Redirect stdout ( > ) into a named pipe ( >() ) running "tee"
exec > >(tee -a "${WORK_DIR}/${REL}.log")
# capture stderr
exec 2>&1


# set the architecture
export SCRAM_ARCH=$ARCH
cd $TMP
echo "TMP" $TMP
# delete old release direcroy in case of an unsuccessful doc process if exists
if [ -d "$TMP/$REL" ]; then
    echo "## I saw that the $REL is already there! I will delete it now."
    rm -rf $TMP/$REL
fi

# create the CMSSW base
cmsrel $REL # huh?
echo $PWD
#scramv1 project CMSSW $REL
checkError "CMSSW could not be initialized properly."
cd $REL

# set the cms env
cmsenv # huh?
#eval `scramv1 runtime -sh`
checkError "CMSSW environments could not be set."

# clone CMSSW repo
git clone git@github.com:cms-sw/cmssw.git src
checkError "Repo could not be cloned."
cd $TMP/$REL/src/
git checkout $REL
cd $TMP/$REL

######## HARD CODED DOCKIT SECTION ########
cd $TMP/$REL/src/Documentation/
echo "go to: $TMP/$REL/src/Documentation/"
rm -rf ReferenceManualScripts/
echo "delete: ReferenceManualScripts"
cp -r $WORK_DIR/ReferenceManualScripts/ .
checkError "I coldn't copy the directory, i cmsdoxy/cmsdoxy/ReferenceManualScripts/scripts"
echo "cp -r cmsdoxy/cmsdoxy/ReferenceManualScripts/scripts `pwd`"
cd $TMP/$REL/src/Documentation/ReferenceManualScripts/scripts 
tcsh generate_reference_manual > /dev/null
checkError "I couldn't generate the refman..."
# add check point here!
######## HARD CODED DOCKIT SECTION ########

# clean up the base
cd $TMP/$REL
rm -rf biglib/ bin/ cfipython/ config/ include/ lib/ logs/ objs/ python/ src/ test/ tmp/ DocKit/
#gzip -r -S gz doc/
echo "generated on $(date)" > auto.doc.2

cd $BASE
#python $BASE/semaphore.py $IOFILE $REL "documented"
checkError "$IOFILE could not be updated."
#scp $IOFILE cmsdoxy@cmssdt01.cern.ch:/data/doxygen/CMSSWAutoDoc
#cp $IOFILE /eos/project/c/cmsweb/www/cmssdt/doxygen/CMSSWAutoDoc 

# upload ref man files (hardcoded username & machine!)
echo "## uploading files..."
cd $TMP
zip -r ${REL}.zip $REL
EOS_DIR="/eos/project/c/cmsweb/www/cmssdt/doxygen/cmssw"
if [ -d /eos/project/c/cmsweb/www/cmssdt ] ; then
  SSH_OPT="-o IdentitiesOnly=yes -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -o ServerAliveInterval=60"
  scp $REL.zip $SSH_OPT cmsbuild@lxplus.cern.ch:${EOS_DIR}/$REL.zip
  scp ${WORK_DIR}/${REL}.log $SSH_OPT cmsbuild@lxplus.cern.ch:${EOS_DIR}/${REL}.log
else
  cp -f $REL.zip ${EOS_DIR}/$REL.zip
  cp -f ${WORK_DIR}/${REL}.log ${EOS_DIR}/${REL}.log
fi
checkError "auto-generated documentation could not be uploaded."

cd $WORK_DIR

echo "## document for $REL has been created."
echo ""
