function slideLoaded(img){
    var $img = $(img),
        $slideWrapper = $img.parent(),
        total = $slideWrapper.find('img').length,
        percentLoaded = null;
 
    $img.addClass('loaded');
 
    var loaded = $slideWrapper.find('.loaded').length;
 
    if(loaded == total){
        percentLoaded = 100;
        // INSTANTIATE PLUGIN
        $slideWrapper.easyFader();
    } else {
        // TRACK PROGRESS
        percentLoaded = loaded/total * 100;
    }
}