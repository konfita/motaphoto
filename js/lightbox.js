document.addEventListener('DOMContentLoaded', function() {
  const lightbox = document.getElementById('lightbox');
  const lightboxImage = document.querySelector('.lightbox__image');
  const lightboxTitle = document.querySelector('.lightbox__title');
  const closeBtn = document.querySelector('.lightbox__close');
  const nextBtn = document.querySelector('.lightbox__next');
  const prevBtn = document.querySelector('.lightbox__prev');
  const loader = document.querySelector('.lightbox__loader');

  let currentPhotoId = null;
  let photosList = [];

  // Ouvrir la lightbox
  document.querySelectorAll('.fullscreen-icon').forEach(icon => {
      icon.addEventListener('click', function(e) {
          const photoItem = this.closest('.photo-item');
          currentPhotoId = photoItem.dataset.photoId;
          photosList = JSON.parse(photoItem.dataset.photosList);
          
          loadPhotoData(currentPhotoId);
          lightbox.classList.remove('hidden');
      });
  });

  // Fermer la lightbox
  closeBtn.addEventListener('click', () => toggleLightbox(false));
  lightbox.querySelector('.lightbox__overlay').addEventListener('click', () => toggleLightbox(false));

  // Navigation
  nextBtn.addEventListener('click', () => navigatePhoto('next'));
  prevBtn.addEventListener('click', () => navigatePhoto('prev'));

  function toggleLightbox(show) {
      lightbox.classList.toggle('hidden', !show);
      document.body.style.overflow = show ? 'hidden' : '';
  }

  async function loadPhotoData(photoId) {
      loader.classList.remove('hidden');
      
      try {
          const response = await jQuery.ajax({
              url: lightbox_vars.ajax_url,
              type: 'POST',
              data: {
                  action: 'get_photo_data',
                  nonce: lightbox_vars.nonce,
                  photo_id: photoId
              }
          });

          if(response.success) {
              lightboxImage.src = response.data.image_url;
              lightboxTitle.textContent = response.data.title;
              currentPhotoId = photoId;
          }
      } catch (error) {
          console.error('Erreur:', error);
      } finally {
          loader.classList.add('hidden');
      }
  }

  function navigatePhoto(direction) {
      const currentIndex = photosList.findIndex(id => id == currentPhotoId);
      let newIndex = direction === 'next' ? currentIndex + 1 : currentIndex - 1;
      
      if(newIndex < 0) newIndex = photosList.length - 1;
      if(newIndex >= photosList.length) newIndex = 0;
      
      currentPhotoId = photosList[newIndex];
      loadPhotoData(currentPhotoId);
  }
});