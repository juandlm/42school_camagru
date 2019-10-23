const	stickerCarousel = document.querySelector("[data-target='stickerCarousel']"),
		sticker = stickerCarousel.querySelector("[data-target='sticker']"),
		leftButton = document.querySelector("[data-action='slideLeft']"),
		rightButton = document.querySelector("[data-action='slideRight']"),
		stickerCarouselWidth = stickerCarousel.offsetWidth,
		stickerStyle = sticker.currentStyle || window.getComputedStyle(sticker),
		stickerMarginRight = Number(stickerStyle.marginRight.match(/\d+/g)[0]),
		stickerCount = stickerCarousel.querySelectorAll("[data-target='sticker']").length,
		maxX = -((stickerCount / 5) * stickerCarouselWidth + 
				(stickerMarginRight * (stickerCount / 5)) - 
				stickerCarouselWidth - stickerMarginRight);
let offset = 0;

leftButton.addEventListener("click", () => {
	if (offset !== 0) {
		offset += stickerCarouselWidth + stickerMarginRight;
		stickerCarousel.style.transform = "translateX(" + offset + "px)";
	}
});
  
rightButton.addEventListener("click", () => {
	if (offset !== maxX) {
		offset -= stickerCarouselWidth + stickerMarginRight;
		stickerCarousel.style.transform = "translateX(" + offset + "px)";
	}
});