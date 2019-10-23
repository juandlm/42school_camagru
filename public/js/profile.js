window.onload = init();

var profileEditElements,
	pPic,
	pPicModal,
	pPicModalClose;

function init() {
	profileEditElements = {editBtn: document.getElementById('editBtn'), 
							saveBtn: document.getElementById('saveBtn'),
							cancelBtn: document.getElementById('cancelBtn'),
							editNameField: document.getElementById('editNameField'),
							editBioField: document.getElementById('editBioField'),
							userName: document.getElementById('userName'),
							userBio: document.getElementById('userBio')};
	pPic = document.getElementById("pPic");
	pPicModal = document.getElementById("pPicModal");
	pPicModalClose = document.querySelector(".closemodal");
}
if (profileEditElements.editBtn)
	profileEditElements.editBtn.addEventListener("click", () => {
			for (let key in profileEditElements)
				profileEditElements[key].classList.toggle("d-none");
	});
if (profileEditElements.cancelBtn)
	cancelBtn.addEventListener("click", () => {
		for (let key in profileEditElements)
			profileEditElements[key].classList.toggle("d-none"); 
	});
if (pPic) {
	pPic.addEventListener("click", () => pPicModal.classList.toggle("d-none"));
	pPicModalClose.addEventListener("click", () => pPicModal.classList.toggle("d-none"));
	window.addEventListener("click", (event) => event.target == pPicModal ? pPicModal.classList.toggle("d-none") : null);
}
