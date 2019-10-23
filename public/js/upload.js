window.onload = init();

const profilePage = Boolean(window.location.pathname.split('/').indexOf("profile") >= 0);

var fileNode, dropZone, pPicModal, pPicSpinner, pPicImg,
	ulRes, ulResImg, ulResDiag, ulInput, mimeTypes,
	validFiles, formData, ajax;

function init() {
	fileNode = document.getElementById('imgUl'),
	dropZone = document.getElementById('dropzone'),
	pPicModal = document.getElementById("pPicModal"),
	pPicSpinner = document.getElementById("pPicSpinner"),
	pPicImg = document.getElementById("pPicImg"),
	ulRes = document.getElementById("uploadResult"),
	ulResImg = document.getElementById("uploadedImg"),
	ulResDiag = document.getElementById("uploadResultDiag"),
	ulInput = document.getElementById("uploadInput"),
	mimeTypes = [ "image/jpg", "image/jpeg", "image/png" ],
	validFiles = [],
	formData = new FormData(),
	ajax = new XMLHttpRequest();
}
	
function startUpload(argfiles) {
	if (!argfiles)
		return alert("No file was selected.");
	if (argfiles.length > 1)
		return alert("You can only upload one file at a time.");
	for (let i = 0; i < argfiles.length; i++) {
		if (mimeTypes.indexOf(argfiles[i].type) == -1)
			return alert("Only .jpeg and .png files are allowed.");
		else if (argfiles[i].size > 2000000)
			return alert("Maximum image size is 2MB.");
		else {
			validFiles.push(argfiles[i]);
			formData.append("image", argfiles[i]);
		}
	}
	ajax.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
			let json = JSON.parse(this.responseText);
			if (json && json.status === true) {
				formData = new FormData();
				handleImage(json.url);
				validFiles = [];
			}
            if (!json || json.status !== true) {
				uploadError(json.error);
				return document.location.reload(true);
			}
		}
	}
	ajax.open("POST", profilePage ? "../uploadProfilePicture" : "processUpload", true);
    ajax.send(formData);
}
if (fileNode)
	fileNode.addEventListener('change', function(event) {
		event.preventDefault();
		if (profilePage) {
			pPicImg.setAttributeNS("http://www.w3.org/1999/xlink", "href", "");
			pPicSpinner.classList.toggle("d-none");
		}
		startUpload(this.files);
	});

if (!profilePage) {
	dropZone.addEventListener('drop', function(event) {
		event.preventDefault();
		this.classList.remove('faux-hvr-grow');
		startUpload(event.dataTransfer.files);
	}, false);
		
	dropZone.addEventListener('dragover', function(event) {
		event.preventDefault();
		this.classList.add('faux-hvr-grow');
	}, false);

	dropZone.addEventListener('dragleave', function(event) {
		event.preventDefault();
		this.classList.remove('faux-hvr-grow');
	}, false)
}

function uploadError(error) {
    alert(error || 'Something went wrong');
}

function handleImage(url) {
	let postBtn = document.getElementById("postBtn"),
		confirmPostDiag = document.getElementById("confirmPostDiag"),
		confirmPostBtn = document.getElementById("confirmPostBtn"),
		cancelPostBtn = document.getElementById("cancelPostBtn"),
		saveBtn = document.getElementById("saveBtn"),
		deleteBtn = document.getElementById("deleteBtn"),
		imgName;

	fileNode.value = "";
	
	imgName = url.split("/");
	imgName = imgName[imgName.length - 1].replace(/.jpg|.jpeg|.png/g, "")

	if (profilePage) {
		pPicModal.classList.toggle("d-none");
		pPicSpinner.classList.toggle("d-none");
		pPicImg.setAttributeNS("http://www.w3.org/1999/xlink", "href", url);
		return;
	}

	postBtn.onclick = () => {
		ulResDiag.classList.toggle("d-none");
		confirmPostDiag.classList.toggle("d-none");
	};
	confirmPostBtn.onclick = () => {
		let submitPost = confirmPostDiag.getElementsByTagName("FORM")[0];
		submitPost.action = "./postupload/" + imgName;
		submitPost.submit();
	};
	cancelPostBtn.onclick = () => {
		ulResDiag.classList.toggle("d-none");
		confirmPostDiag.classList.toggle("d-none");
		confirmPostBtn.href = '';
	};
	saveBtn.href = "./saveupload/" + imgName + "/upload";
	deleteBtn.href = "./deleteupload/" + imgName + "/upload";

	ulResImg.getElementsByClassName("img-thumbnail")[0].src = url;
	ulRes.classList.toggle("d-none");
	ulInput.classList.toggle("d-none");
}

function postSavedImage(imgName) {
	let response = prompt("Enter a description for your post or leave this empty."),
		postForm = document.getElementById("postForm"),
		postDescription = document.getElementById("postDescription");

	postForm.action = "./postupload/" + imgName;
	if (response === null)
		return;
	else if (response === '')
		response = '';
	postDescription.value = response;
	postForm.submit();
}