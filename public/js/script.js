// jQuery.noConflict();
$(document).ready(function() {
  $('.chart-1 img').each(function(){
    var art = $(this);
    art.attr('src',art.attr('src').replace('100x100','300x300'));
  }); 
  $("#Form_WeekSelectForm_Settimana").select2();
  $('#Form_WeekSelectForm_Settimana').on('change', function(valore) {
    $('#Form_WeekSelectForm').submit();
  }); 
});

if ('loading' in HTMLImageElement.prototype) {
  const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
   img.src = img.dataset.src;
  });
} else {
  // Dynamically import the LazySizes library
  const script = document.createElement('script');
  script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
  document.body.appendChild(script);
}