
function generateInvite() {
    var absolutePath = getApiDir()  + "/user/generateinvite.php";

    $.ajax({
        type: "POST"
        , url: absolutePath
        , data: null
        , success: function (data) {
            getInvites();
        }
    });
}

function getInvites() {
    var absolutePath = getApiDir()  + "/user/invitescollection.php";
    var inviteTableTag = $("#inviteTable");

    $.ajax({
        type: "POST"
        , url: absolutePath
        , data: null
        , success: function (data) {
            var invites = data["invites"];
            var html = inviteTableTag.html();

            html = "<tr>\n" +
                            "<td>\n" +
                                "<label>User ID</label>\n" +
                            "</td>\n" +
                            "<td>\n" +
                                "<label>Owner</label>\n" +
                            "</td>\n" +
                            "<td>\n" +
                                "<label>Creation Date</label>\n" +
                            "</td>\n" +
                    "</tr>";

            if (invites.length > 0) {
                invites.forEach(invite => {
                    html += "<tr>\n" +
                                "<td>\n" +
                                    "<label>" + invite["id"] + "</label>\n" +
                                "</td>\n" +
                                "<td>\n" +
                                    "<label>" + invite["username"] + "</label>\n" +
                                "</td>\n" +
                                "<td>\n" +
                                    "<label>" + invite["invite_code"] + "</label>\n" +
                                "</td>\n" +
                            "</tr>";
                });
            }

            inviteTableTag.html(html);
        }
    });
}

getInvites();