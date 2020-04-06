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




// function gaPopup(theUrl){
//   window.open(theUrl,'popup','width=600,height=600');
//   console.log('santiy?');
// }

// jQuery('#submissionModal').on('show.bs.modal', function (event) {
//   var button = jQuery(event.relatedTarget); // Button that triggered the modal
//   console.log(button.data('tag'));
//   if(button.data('tag')){
//     var tag = button.data('tag'); // Extract info from data-* attributes
//   }
//   var modal = jQuery(this);
//   modal.find('#input_1_5').val(tag);
// })


// jQuery('#submissionModal').on('hide.bs.modal', function () {
//   location.reload(true);
// });




if (document.getElementById('insta-pot')){
  const igUrl = 'https://www.instagram.com/explore/tags/fotofika/?__a=1'

  let markup = '';
  let altText ='';

    fetch(igUrl).then(function(response) {
        var contentType = response.headers.get("content-type");
        if (contentType && contentType.indexOf("application/json") !== -1) {
          return response.json().then(function(json) {
            const igs = json.graphql.hashtag.edge_hashtag_to_media.edges;
          
            igs.forEach(function(element){
              if (element.node.edge_media_to_caption.edges[0]){
                 altText = element.node.edge_media_to_caption.edges[0].node.text;
              } else {
                 altText = 'a picture involving ' + tag 
              }
              markup = `<div class="col-md-3"><a href="https://www.instagram.com/p/${element.node.shortcode}"  target="_blank" ><img src="${element.node.thumbnail_src}" alt="${altText}"></a></div>` + markup;                     
            })
          })
        }
    }).then(function(){
          console.log(document.getElementById('ig-holder'))
          document.getElementById('insta-pot').innerHTML = markup;
    })



}