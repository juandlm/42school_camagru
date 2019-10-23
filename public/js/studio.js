window.onload = init();

navigator.getUserMedia = (navigator.getUserMedia ||
	navigator.webkitGetUserMedia ||
	navigator.mozGetUserMedia ||
	navigator.msGetUserMedia);

var video, webcamStream;

if (navigator.getUserMedia) {
	navigator.getUserMedia(
		{
			video: {
				width: 1280,
				height: 720
			},
			audio: false
		},
		function(stream) {
			video = document.querySelector('#video');
			video.srcObject = stream;
			webcamStream = stream;
		},
		function(err) {
			console.log("An error occured! " + err);
		}
	);
} else
	console.log("getUserMedia not supported");

var canvas, ctx, screen, stickers, checkedStickers,
	active, clearBtn, captureBtn, confirmBtns, ulRes,
	ulResImg, ulResDiag;

function init() {
	canvas = document.getElementById("canvas");
	ctx = canvas.getContext("2d");
	screen = document.getElementById("screenWrapper");
	stickers = document.getElementsByName("sticker");
	active = 0;
	clearBtn = document.getElementById("clearStickers");
	captureBtn = document.getElementById("captureButton");
	confirmBtns = document.getElementById("confirmbtnsWrapper");
	ulRes = document.getElementById("uploadResult"),
	ulResImg = document.getElementById("uploadedImg"),
	ulResDiag = document.getElementById("uploadResultDiag");
	// resDiag = document.getElementById("resDiag");
	toggleStickers();
}

function toggleStickers() {
	let stickerEl;
	for (let i = 0 ; i < stickers.length; i++) {
		stickers[i].addEventListener('change', (event) => {
			stickerEl = document.getElementById(event.target.value + 'Sticker');
			if (event.target.checked) {
				stickerEl.classList.remove("d-none");
				active++;
			} else {
				stickerEl.classList.add("d-none");
				active--;
			}
			if (captureBtn.disabled = Boolean(active <= 0)) {
				captureBtn.textContent = "Locked";
				captureBtn.classList.remove("btn-outline-success");
				captureBtn.classList.add("btn-outline-dark");
			} else {
				captureBtn.textContent = "Capture";
				captureBtn.classList.remove("btn-outline-dark");
				captureBtn.classList.add("btn-outline-success");
			}
		});
	}
	clearBtn.addEventListener('click', function() {
		for (let i = 0 ; i < stickers.length; i++) {
			stickers[i].checked = false;
			stickerEl = document.getElementById(stickers[i].value + 'Sticker');
			stickerEl.classList.add("d-none");
		}
		active = 0;
		captureBtn.disabled = true;
		captureBtn.textContent = "Locked";
		captureBtn.classList.remove("btn-outline-success");
		captureBtn.classList.add("btn-outline-dark");
	});
}

function snapshot() {
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
	toggleDisplay();
}

function toggleDisplay() {
	canvas.classList.toggle("d-none");
	confirmBtns.classList.toggle("d-none")
	captureBtn.classList.toggle("d-none");
	video.classList.toggle("d-none");
}

function processSnapshot(choice) {
	switch (choice) {
		case "y":
			processStickers();
			let imgEncoded = canvas.toDataURL('image/png'),
				headers = {
					"Content-Type": "application/json",
					"Access-Control-Allow-Origin": "*"
				},
				content = {
					"stickers": checkedStickers,
					"img_encoded": imgEncoded
				};
			fetch("processSnapshot", {
				method: "POST",
				headers: headers,
				body: JSON.stringify(content)
			})
				.then((response) => response.json())
				.then((data) => handleImage(data))
				.catch((error) => console.log(error));
			break;
		case "n":
			clearBtn.dispatchEvent(new Event("click"));
			toggleDisplay();
			break;
	}
}

function processStickers() {
	checkedStickers = [];
	for (let i = 0; i < stickers.length; i++)
		if (stickers[i].checked)
			checkedStickers[i] = stickers[i].value + ".png";
	checkedStickers = checkedStickers.filter(i => (i != null));
}

function handleImage(data) {
	let postBtn = document.getElementById("postBtn"),
		confirmPostDiag = document.getElementById("confirmPostDiag"),
		confirmPostBtn = document.getElementById("confirmPostBtn"),
		cancelPostBtn = document.getElementById("cancelPostBtn"),
		saveBtn = document.getElementById("saveBtn"),
		deleteBtn = document.getElementById("deleteBtn"),
		imgName;

	imgName = data.url.split("/");
	imgName = imgName[imgName.length - 1].replace(/.jpg|.jpeg|.png/g, "");

	
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
	saveBtn.href = "./saveupload/" + imgName + "/create";
	deleteBtn.href = "./deleteupload/" + imgName + "/create";

	ulResImg.getElementsByClassName("img-thumbnail")[0].src = data.url;
	ulRes.classList.toggle("d-none");
	screen.classList.toggle("d-none");
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