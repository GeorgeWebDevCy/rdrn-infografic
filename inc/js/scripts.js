const hero_swiper = new Swiper('.home_swiper', {
    direction: 'horizontal',
    loop: true,
    slidesPerView: 1,
    spaceBetween: 30,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    on: {
      touchEnd: function () {
          document.querySelector('#hero .swipe').classList.add('d-none');
      }
    },
});

const news_swiper = new Swiper('.news_swiper', {
  direction: 'horizontal',
  loop: true,
  slidesPerView: 1,
  spaceBetween: 30,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    768: {
      slidesPerView: 2, 
      spaceBetween: 20,
    },
    1200: {
      slidesPerView: 3, 
      spaceBetween: 20, 
    },
    1400: {
      slidesPerView: 4, 
      spaceBetween: 20, 
    }
  },
  on: {
    touchEnd: function () {
        document.querySelector('#news-slider .swipe').classList.add('d-none');
    }
  },
});

const footer_logos = new Swiper('#footer_logos', {
  direction: 'horizontal',
  loop: true,
  slidesPerView: 3,
  spaceBetween: 30,
  autoplay: {
    delay: 2000,  
  },
  speed: 5000, 
  breakpoints: {
    768: {
      slidesPerView: 5, 
      spaceBetween: 30, 
    },
    1200: {
      slidesPerView: 6, 
      spaceBetween: 40,
    },
    1400: {
      slidesPerView: 7, 
      spaceBetween: 60, 
    }
  },
});

//TOOLTIPS
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

//LOGIN
document.getElementById('modalLoginForm').addEventListener('submit', function(event) {
  event.preventDefault();

  //disable login and show loading
  document.getElementById('login_button_load').classList.remove('d-none');
  document.getElementById('login_button').disabled = true;

  const ajaxUrlInput = document.getElementById('ajax_url').value;
  const loginErrorDiv = document.getElementById('login_error');
  
  var formData = new FormData(this);
  formData.append('action', 'ajax_login');

  var recaptchaResponse = grecaptcha.getResponse();
  formData.append('g-recaptcha-response', recaptchaResponse);

  fetch(ajaxUrlInput, {
      method: 'POST',
      headers: {
          'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
  })
  .then(response => response.json())
  .then(response => {
    document.getElementById('login_button_load').classList.add('d-none');
    document.getElementById('login_button').disabled = false;
      if (response.success) {
        loginErrorDiv.classList.add('d-none');
        window.location.href = localData.members_URL;
      } else {
        loginErrorDiv.innerHTML = response.data || 'An unknown error occurred.';
        loginErrorDiv.classList.remove('d-none');
        grecaptcha.reset(); 
      }
  })
  .catch(error => {
      console.error('Error:', error);
      alert('An error occurred: ' + error.message);
      grecaptcha.reset(); 
  });
});

//Send email verification
document.addEventListener('click', function(event) {
  if (event.target && event.target.id === 'resendverification') {

    event.preventDefault();

    const form = document.getElementById('resendverification_form');
    const ajaxUrlInput = document.getElementById('ajax_url').value;
    const formData = new FormData(form);
    formData.append('action', 'resend_verification');

    fetch(ajaxUrlInput, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
    })
    .then(response => response.json())
    .then(response => {
      const loginErrorDiv = document.getElementById('login_error');
      const loginSuccessDiv = document.getElementById('login_success');
      if (response.success) {
        loginSuccessDiv.innerHTML = 'The email verification link has been resent.';
        loginSuccessDiv.classList.remove('d-none');
        loginErrorDiv.classList.add('d-none');
      } else {
        loginErrorDiv.innerHTML = response.data || 'An unknown error occurred.';
        loginErrorDiv.classList.remove('d-none');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred: ' + error.message);
    });
  }
});

//show login modal 
if (window.location.search.includes('?login')) {
  var loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {
    backdrop: 'static',
    keyboard: false
  });
  loginModal.show();
}

//show login modal 
if (window.location.search.includes('?join')) {
  var loginModal = new bootstrap.Modal(document.getElementById('regModal'), {
    backdrop: 'static',
    keyboard: false
  });
  loginModal.show();
}
