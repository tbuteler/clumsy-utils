(function() {

    function extractVimeoID(url){
        var explodedURL = url.split('/');
        var vimeoID = explodedURL.slice(-1).toString();

        return vimeoID;
    }

    function extractYoutubeID(url){
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/i;
        var match = url.match(regExp);
        if (match && match[7].length == 11) {
            return match[7];
        } else{
            return null;
        }
    }

    function extractVideoID(url){

        var videoData = {};

        if(url.search(/youtu\.?be/i) !== -1){
            videoData.videoID = extractYoutubeID(url);
            videoData.videoSource = 'youtube';
        } else if(url.search('vimeo') !== -1){
            videoData.videoID = extractVimeoID(url);
            videoData.videoSource = 'vimeo';
        }
        return videoData;
    }

    function appendVideo(element, videoData){
        switch(videoData.videoSource){
            case 'youtube':
                $videoIframe = '<iframe src="https://www.youtube.com/embed/' +
                    videoData.videoID + '" frameborder="0" allowfullscreen></iframe>';
                break;
            case 'vimeo':
                $videoIframe = '<iframe src="https://player.vimeo.com/video/' +
                    videoData.videoID + '" frameborder="0" mozallowfullscreen allowfullscreen></iframe>';
                break;
            default:
                return false;
        }

        $(element).find('.placeholders .glyphicon').hide();
        $(element).append($videoIframe);

    }

    $(window).load(function(){
        $('.embed-video-wrapper input').each(function() {
            var elem = $(this);

            elem.data('oldVal', elem.val());
            if (elem.val() != '') {
                var id = extractVideoID(elem.val());
                if (id != null) {
                    $el = $(this).parents('.embed-video-wrapper').find('.preview-box');
                    appendVideo($el,id);
                }
            };

            // Look for changes in the value
            elem.bind("propertychange change click keyup input paste", function(event){

                // If value has changed...
                if (elem.data('oldVal') != elem.val()) {
                    $el = $(this).parents('.embed-video-wrapper').find('.preview-box');

                    $(this).parents('.embed-video-wrapper').find('iframe').remove();
                    $el.find('.placeholders .glyphicon').show();
                    $el.find('.placeholders .error').hide();
                    $(elem).removeClass('has-error');

                    // Updated stored value
                    elem.data('oldVal', elem.val());

                    var id = extractVideoID(elem.val());

                    if (Object.keys(id).length) {
                        appendVideo($el,id);
                    }
                    else if (elem.val() != '') {
                        $el.find('.placeholders .idle').hide();
                        $el.find('.placeholders .error').show();
                        $(elem).addClass('has-error');
                    }
                }
            });
        });
    });

})();
