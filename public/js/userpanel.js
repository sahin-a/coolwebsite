var idx = 0;
var videos = new Array();

window.addEventListener('load', function () {
    loadVideos();
    updateVideo();
})

$(document).ready(function () {

});

function updateVideo() {
    var video = videos[idx];

    var submitterTag = $("#videoSubmitter");
    submitterTag.html(video["submitter"]);

    var videoMessageTag = $("#videoMessage");
    videoMessageTag.html(video["message"]);

    var videoSubmitDateTag = $("#videoSubmitDate");
    videoSubmitDateTag.html(video["submit_date"]);

    var videoId = video["videoId"];
    var videoRow = $("#videoRow");
    videoRow.html("<iframe id=\"videoFrame\" class=\"embed-responsive-item\" src=\"https://www.youtube.com/embed/" + videoId + "\"\n" +
        "                        allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"\n" +
        "                        allowfullscreen></iframe>");
}

function loadVideos() {
    var protocol = window.location.protocol + "//";
    var host = window.location.host;

    var rootName = $(location).attr('pathname');
    rootName.indexOf(1);
    rootName = rootName.split("/")[1];

    var href = location.href;
    var absolutePath = protocol + host + "/" + rootName + "/api/youtube/videocollection.php";

    $.get(absolutePath,
        function (data) {
            for (var i = 0; i < data.length; i++) {
                var videoObj = data[i];
                videos.push(videoObj);
            }
        });
}

function previousVideo() {
    idx = idx > 0 ? --idx : idx;
    updateVideo();
}

function nextVideo() {
    idx = idx < videos.length - 1 ? ++idx : idx;
    updateVideo();
}