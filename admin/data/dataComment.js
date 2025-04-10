let HOST_URL = "https://mmi.unilim.fr/~lippler1/SAE203-Manon";

let DataComment = {};

DataComment.getPendingComments = async function () {
  const response = await fetch(`${HOST_URL}/server/script.php?todo=getPendingComments`);
  return await response.json();
};

DataComment.approveComment = async function (commentId) {
  const response = await fetch(`${HOST_URL}/server/script.php?todo=approveComment&comment_id=${commentId}`);
  return await response.json();
};

DataComment.deleteComment = async function (commentId) {
  const response = await fetch(`${HOST_URL}/server/script.php?todo=deleteComment&comment_id=${commentId}`);
  return await response.json();
};

export { DataComment };