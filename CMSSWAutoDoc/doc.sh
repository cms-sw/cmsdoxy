#!/bin/bash -ex

# get the scram
shopt -s expand_aliases
source /cvmfs/cms.cern.ch/cmsset_default.sh

WORK_DIR=$(/bin/pwd -P)
BASE=$(dirname $(readlink -f "${BASH_SOURCE[0]}"))
cd $BASE
TMP="${WORK_DIR}/TMP"
rm -rf $TMP
mkdir $TMP
ARCH=$ARCHITECTURE
REL=$RELEASE_FORMAT

# set the architecture
export SCRAM_ARCH=$ARCH
cd $TMP

# create the CMSSW base
scram project CMSSW $REL
cd $REL

# set the cms env
eval `scramv1 runtime -sh`
which doxygen

# clone CMSSW repo
wget -q https://github.com/cms-sw/cmssw/archive/refs/tags/${REL}.tar.gz
tar -xzf ${REL}.tar.gz
rm -rf src ${REL}.tar.gz
mv cmssw-${REL} src

######## HARD CODED DOCKIT SECTION ########
$WORK_DIR/ReferenceManualScripts/scripts/generate_reference_manual
######## HARD CODED DOCKIT SECTION ########

# clean up the base
cd $TMP
mv $REL ${REL}.tmp
mkdir $REL
mv ${REL}.tmp/doc ${REL}/
[ -e ${REL}.tmp/${REL}.index ] && mv ${REL}.tmp/${REL}.index ${REL}/
rm -rf ${REL}.tmp
zip -r ${REL}.zip $REL
