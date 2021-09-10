#!/bin/bash -ex

# get the scram
shopt -s expand_aliases
source /cvmfs/cms.cern.ch/cmsset_default.sh

WORK_DIR=$(/bin/pwd)
BASE=$(dirname $(readlink -f "${BASH_SOURCE[0]}"))
cd $BASE
TMP="${WORK_DIR}/TMP"
rm -rf $TMP
mkdir $TMP
ARCH=$ARCHITECTURE
REL=$RELEASE_FORMAT

# Redirect stdout ( > ) into a named pipe ( >() ) running "tee"
exec > >(tee -a "${WORK_DIR}/${REL}.log")
# capture stderr
exec 2>&1


# set the architecture
export SCRAM_ARCH=$ARCH
cd $TMP

# create the CMSSW base
scram project CMSSW $REL
cd $REL

# set the cms env
eval `scramv1 runtime -sh`

# clone CMSSW repo
wget -q https://github.com/cms-sw/cmssw/archive/refs/tags/${REL}.tar.gz
tar -xzf ${REL}.tar.gz
rm -rf src ${REL}.tar.gz
mv cmssw-${REL} src

######## HARD CODED DOCKIT SECTION ########
rm -rf src/Documentation/ReferenceManualScripts/
cp -r $WORK_DIR/ReferenceManualScripts/ src/Documentation/
pushd src/Documentation/ReferenceManualScripts/scripts 
  tcsh generate_reference_manual > /dev/null
popd
######## HARD CODED DOCKIT SECTION ########

# clean up the base
rm -rf biglib/ bin/ cfipython/ config/ include/ lib/ logs/ objs/ python/ src/ test/ tmp/ DocKit/

cd $TMP
zip -r ${REL}.zip $REL
