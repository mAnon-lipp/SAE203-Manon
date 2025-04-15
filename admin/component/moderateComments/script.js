import { DataComment } from "../../data/dataComment.js";

let commentTemplateFile = await fetch("./component/moderateComments/template.html");
let commentTemplate = await commentTemplateFile.text();

let Comment = {};

Comment.format = function () {
  return commentTemplate;
};

Comment.loadPendingComments = async function () {
  const comments = await DataComment.getPendingComments();
  const commentsList = document.querySelector("#comments-list");

  if (!commentsList) {
    console.error("Element with ID 'comments-list' not found in the DOM.");
    return;
  }

  if (comments.length === 0) {
    commentsList.innerHTML = "<p>Aucun commentaire à modérer pour le moment.</p>";
    return;
  }

  let commentsHTML = "";
  for (const comment of comments) {
    commentsHTML += `
      <div class="comment">
        <p><strong>${comment.profile_name}</strong> (${comment.created_at}):</p>
        <p>${comment.comment}</p>
        <button onclick="Comment.approveComment(${comment.id})">Approuver</button>
        <button onclick="Comment.deleteComment(${comment.id})">Supprimer</button>
      </div>
    `;
  }
  commentsList.innerHTML = commentsHTML;
};

Comment.approveComment = async function (commentId) {
  const response = await DataComment.approveComment(commentId);
  alert(response);
  Comment.loadPendingComments();
};

Comment.deleteComment = async function (commentId) {
  const response = await DataComment.deleteComment(commentId);
  alert(response);
  Comment.loadPendingComments();
};

window.Comment = Comment;

export { Comment };
