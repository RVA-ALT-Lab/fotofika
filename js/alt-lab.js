//ALT LAB STUFF

// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("wrapper-navbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop+60;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

//make videos full size no matter what
var videos = document.querySelectorAll('iframe[src^="https://www.youtube.com/"], iframe[src^="https://player.vimeo.com"], iframe[src^="https://www.youtube-nocookie.com/"]'); //get video iframes

for (var i = 0; i < videos.length; i++) {
    var el = videos.item(i);      
      var wrapper = document.createElement('div'); //create wrapper 
      wrapper.classList.add("video-responsive"); //give wrapper the class      
      el.parentNode.insertBefore(wrapper, el); //insert wrapper      
      wrapper.appendChild(el); // move video into wrapper
}

//popup album confirmation 
jQuery(document).bind("gform_confirmation_loaded", function (e, form_id) {
  console.log('fired');
  google_album_confirmation();
});

jQuery( document ).ready(function() {
    google_album_confirmation();
});

function google_album_confirmation(){
  if (document.getElementById('verify-album')){
    var albumLink = document.getElementById('verify-album');
    var theUrl = albumLink.getAttribute('href');
   albumLink.addEventListener("click", function(){gaPopup(theUrl)});
  }
}


function gaPopup(theUrl){
  window.open(theUrl,'popup','width=600,height=600');
  console.log('santiy?');
}

jQuery('#submissionModal').on('show.bs.modal', function (event) {
  var button = jQuery(event.relatedTarget); // Button that triggered the modal
  console.log(button.data('tag'));
  if(button.data('tag')){
    var tag = button.data('tag'); // Extract info from data-* attributes
  }
  var modal = jQuery(this);
  modal.find('#input_1_5').val(tag);
})


jQuery('#submissionModal').on('hide.bs.modal', function () {
  location.reload(true);
});


//check for 404 on album entry

  window.onload = function() {
    
    var album = document.getElementById('input_1_3');

    //if (album){
             makeButton();

     // album.addEventListener("onEdit", urlExists);
      album.addEventListener('input',function(e){
      checkUrl(album.value);
      },false);

   // }
  };

  function makeButton (){
    if (document.getElementById('testing-button') === null){     
        jQuery("#input_1_3").after('<div id="testing-button"></div>');
      }
      
  }




function checkUrl(url){
  var goo = url.includes('photos.app.goo.gl',0)
  var share = url.includes('share',0)
  var urlDisplay = document.getElementById('testing-button')
  if (goo === true || share === true ){
    urlDisplay.classList.add('victory')
    urlDisplay.classList.remove('revisit')
  } else {
    urlDisplay.classList.remove('victory')
    urlDisplay.classList.add('revisit')
  }
}
   
