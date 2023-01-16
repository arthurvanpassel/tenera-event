$(document).ready(function(){
  // carousel
  $('section#carousel .images').slick({
    dots: true,
    arrows: false,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 5000,
  });

  // navigation
  $('nav a').click(function(e) {
    e.preventDefault();
    var aid = $(this).attr("href");
    $('html,body').animate({scrollTop: $(aid).offset().top});
  })

  // form
  urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('errors')) {
    var error_keys = urlParams.get('errors').split(',')
    var fields_keys = urlParams.get('fields').split(',')
    for (let i = 0; i < fields_keys.length; i++) {
      const element = fields_keys[i];
      var temp = element.split(":")
      $('#'+temp[0]).val(temp[1]);
    }
    for (let i = 0; i < error_keys.length - 1; i++) {
      const element = error_keys[i];
      var temp = element.split(":")
      if (temp[1] == "required") {
        $( "<p class='error'>Dit is een verplicht veld</p>" ).insertAfter( '#'+temp[0] )
      } else if (temp[1] == "e-mail") {
        $( "<p class='error'>Vul een geldig e-mailadres in</p>" ).insertAfter( '#'+temp[0] )
      }
    }
    $('html,body').animate({scrollTop: $('#schrijf-in').offset().top});
  }
  else if (urlParams.get('errorMail')) {
    $( "<p>&nbsp;</p><p class='error'>Er liep iets fout, probeer het later opnieuw.</p><p class='error'>Als het probleem blijft voordoen, stuur uw inschrijving dan via e-mail door naar <a href='mailto:peter.ottevaere@telenet.be' target='_blank'>peter.ottevaere@telenet.be</a></p>" ).insertBefore('.form-group.first')
    $('html,body').animate({scrollTop: $('#schrijf-in').offset().top});
    window.history.pushState({}, document.title, "/");
  } 
  else if (urlParams.get('success')) {
    $( "<p>&nbsp;</p><p class='success'>Uw inschrijving is verstuurd! We laten u zo snel mogelijk iets weten.</p>" ).insertBefore('.form-group.first')
    $('html,body').animate({scrollTop: $('#schrijf-in').offset().top});
    window.history.pushState({}, document.title, "/");
  }
}); 