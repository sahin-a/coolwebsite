var idx = 0;
var videos = new Array();

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

    getComments();
}

function loadVideos() {
    var absolutePath = getApiDir() + "/youtube/videocollection.php";

    $.get(absolutePath, function (data) {
        videos = data["videos"];
        updateVideo();
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

function submitComment() {
    var absolutePath = getApiDir() + "/youtube/submitcomment.php";
    var comment = document.getElementById("commentBox");

    $.ajax({
        type: "POST"
        , url: absolutePath
        , data: {"id": videos[idx]["id"], "comment": comment.value}
        , success: function () {
            getComments();
            comment.value = null;
            alert("comment submitted successfully");
        }
    });
}

function getComments() {
    var absolutePath = getApiDir() + "/youtube/commentcollection.php";
    var commentSectionTag = $("#comment-section");
    commentSectionTag.html("");

    $.ajax({
        type: "POST"
        , url: absolutePath
        , data: {"id": videos[idx]["id"]}
        , success: function (data) {
            var comments = data["comments"];
            var html = "";

            if (comments.length > 0) {
                comments.forEach(comment => {
                    html += "<div class=\"input-group p-1 bg-dark text-white\" id=\"comment\">\n" +
                        "<label class=\"form-control bg-dark btn-outline-info text-white\" \n" +
                        "   id=\"comment-username-label\">" + comment["creation_date"] + " | " + comment["username"] + "</label>\n" +
                        "<label class=\"form-control bg-dark btn-outline-danger text-white\" \n" +
                        "       id=\"comment-username-label\">" + comment["comment"] + "</label>\n" +
                        "</div>";
                });
            }

            commentSectionTag.html(html);
        }
    });
}

loadVideos();