window.onload = init();

var commentInput, commentIcon, likeIcon, likesModal, likesAmount,
	postImage, postCommentBtn, postModal, postForm, editPostBtn;

function init() {
	commentInput = document.querySelector("textarea"),
	commentIcon = document.getElementById("commentIcon"),
	likeIcon = document.getElementById("likeIcon"),
	likesModal = document.getElementById("likesModal"),
	likesAmount = document.getElementById("likesAmount"),
	postImage = document.getElementById("postImage"),
	postCommentBtn = document.getElementById("postCommentBtn"),
	postModal = document.getElementById("postModal"),
	editPostBtn = document.getElementById("editPostBtn");
	loadComments();
}

function loadComments() {
	let loadMore = document.getElementById("loadMore"),
		shownComments = Array.from(document.querySelectorAll(".cmg-comment"));

	if (shownComments)
		shownComments = shownComments.slice(0, 6);
	if (shownComments.length == 6)
		loadMore.classList.remove("d-none");
	for (let key in shownComments)
		shownComments[key].classList.toggle("d-none");

	if (loadMore) {
		loadMore.addEventListener("click", (event) => {
			event.preventDefault();
			let hiddenComments = document.querySelector(".cmg-comments");
			hiddenComments = Array.from(hiddenComments.querySelectorAll(".d-none"));
			hiddenComments = hiddenComments.slice(0, 8);
			if (hiddenComments.length < 8)
				loadMore.classList.toggle("d-none");
			for (let key in hiddenComments)
				hiddenComments[key].classList.toggle("d-none");
		});
	}
}

function editDescription(action, imageId, currentDescription) {
	let response = prompt("Enter a new description for your post or leave this empty to remove it.", currentDescription),
		newDescription = document.getElementById("newDescription");

	postForm.action = action;
	if (response === null)
		return;
	else if (response === '')
		response = '';
	newDescription.value = imageId + '/' + response;
	postForm.submit();
}

function deletePost(action) {
	let response = confirm("Are you sure you want to delete your post?");

	postForm.action = action;
	if (response === true)
		postForm.submit();
	else
		event.preventDefault();
}

window.addEventListener("click", (event) => {
	if (postCommentBtn)
		setTimeout(() => postCommentBtn.disabled = (commentInput === document.activeElement) ? false : true, 0);
	if (event.target == likesModal)
		likesModal.classList.toggle("d-none");
	if (event.target == postModal)
		postModal.classList.toggle("d-none");
});

if (editPostBtn)
	editPostBtn.addEventListener("click", () => {
		let postModalCancel = postModal.querySelector(".closemodal");
		postForm = postModal.getElementsByTagName("FORM")[0];
		postModal.classList.toggle("d-none");
		postModalCancel.onclick = () => postModal.classList.toggle("d-none");
	});

if (commentInput) {
	commentIcon.addEventListener("click", () => commentInput.focus());

	let interactionsForm = document.getElementById("interactionsForm"),
		likeIcon0 = interactionsForm.getElementsByTagName("I")[0],
		likeIcon1 = interactionsForm.getElementsByTagName("I")[1],
		animationDelay = likeIcon0.classList.contains("d-none"),
		animateLike = function (animationDelay) {
			setTimeout(() => likeIcon0.classList.toggle("cmg-pop-click"), !animationDelay * 300);
			likeIcon0.classList.toggle("d-none");
			likeIcon1.classList.toggle("d-none");
			setTimeout(() => likeIcon1.classList.toggle("cmg-pop-click"), animationDelay * 300);
			postImage.getElementsByTagName("I")[0].style.visibility = "visible";
			postImage.getElementsByTagName("I")[0].style.opacity = 0.8;
		};

	likeIcon.addEventListener("click", animateLike);

}

if (likesAmount)
	likesAmount.addEventListener("click", () => likesModal.classList.toggle("d-none"));