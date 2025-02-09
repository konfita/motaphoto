document.addEventListener("DOMContentLoaded", function () {
  const lightbox = document.getElementById("lightbox");
  const lightboxImage = document.getElementById("lightbox-image");
  const lightboxTitle = document.getElementById("lightbox-title");
  const closeButton = document.querySelector(".lightbox-close");
  const prevButton = document.querySelector(".lightbox-prev");
  const nextButton = document.querySelector(".lightbox-next");
  let images = [];
  let currentIndex = 0;

  // Récupérer toutes les images de la galerie
  const triggers = document.querySelectorAll(".lightbox-trigger");
  triggers.forEach((trigger, index) => {
      images.push({
          src: trigger.getAttribute("data-src"),
          title: trigger.getAttribute("data-title")
      });

      trigger.addEventListener("click", function (e) {
          e.preventDefault();
          openLightbox(index);
      });
  });

  function openLightbox(index) {
      currentIndex = index;
      lightboxImage.src = images[currentIndex].src;
      lightboxTitle.textContent = images[currentIndex].title;
      lightbox.style.display = "flex";
  }

  function closeLightbox() {
      lightbox.style.display = "none";
  }

  function showPrev() {
      if (currentIndex > 0) {
          openLightbox(currentIndex - 1);
      }
  }

  function showNext() {
      if (currentIndex < images.length - 1) {
          openLightbox(currentIndex + 1);
      }
  }

  closeButton.addEventListener("click", closeLightbox);
  prevButton.addEventListener("click", showPrev);
  nextButton.addEventListener("click", showNext);

  lightbox.addEventListener("click", function (e) {
      if (e.target === lightbox) {
          closeLightbox();
      }
  });
});
