import os

cmssw = os.listdir('./')
for ver in cmssw:
    path = "./%s/doc/html/index.htmlgz" % ver

    if not os.path.exists(path) and "CMSSW_7" in path:
        print ver
        os.system("rm -rf %s" % ver)
