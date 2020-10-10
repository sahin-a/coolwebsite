function getBaseDir() {
    var protocol = window.location.protocol + "//";
    var host = window.location.host;

    var href = location.href;
    var path = protocol + host;

    return path;
}

function getApiDir() {
    // TODO: don't forget to comment this rootName shit out before comitting
    var rootName = $(location).attr('pathname');
    rootName.indexOf(1);
    rootName = rootName.split("/")[1];
    /* "/" + rootName*/

    var href = location.href;
    var absolutePath = getBaseDir() + "/" + rootName + "/api";

    return absolutePath;
}