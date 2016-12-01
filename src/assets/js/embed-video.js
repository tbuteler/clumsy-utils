
$(window).load(function(){
    videoManager.init();
});

var EmbededVideoManager = function() {
    this.init = function() {
        var self = this;
        $('.embed-video-wrapper input').each(function() {
            var elem = $(this);

            elem.data('oldVal', elem.val());

            if (elem.val() !== '') {
                var id = self.extractVideoID(elem.val());
                if (id !== null) {
                    var $el = $(this).parents('.embed-video-wrapper').find('.preview-box');
                    $el.find('.placeholders .idle').hide();
                    self.appendVideo($el,id);
                }
            }

            // Look for changes in the value
            self.bindEvents(elem);

        });
    };

    this.rebuild = function() {

        var self = this;
        $('.embed-video-wrapper input').each(function() {
            var elem = $(this);

            elem.data('oldVal', elem.val());

            // Look for changes in the value
            self.bindEvents(elem);
        });
    };

    this.bindEvents = function(elem) {
        var self = this;

        elem.on('propertychange change click keyup input paste', function(){

            // If value has changed...
            if (elem.data('oldVal') !== elem.val()) {
                $el = $(this).parents('.embed-video-wrapper').find('.preview-box');

                $(this).parents('.embed-video-wrapper').find('iframe').remove();
                $el.find('.placeholders .error').hide();
                elem.removeClass('has-error');

                // Updated stored value
                elem.data('oldVal', elem.val());

                var id = self.extractVideoID(elem.val());

                if (Object.keys(id).length) {

                    $el.find('.placeholders .idle').hide();
                    self.appendVideo($el,id);
                }
                else if (elem.val() !== '') {
                    $el.find('.placeholders .idle').hide();
                    $el.find('.placeholders .error').show();
                    elem.addClass('has-error');
                } else {
                    $el.find('.placeholders .idle').show();
                }
            }
        });
    };

    this.extractVimeoID = function(url) {
        var explodedURL = url.split('/');
        var vimeoID = explodedURL.slice(-1).toString();

        return vimeoID;
    };

    this.extractYoutubeID = function(url){
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/i;
        var match = url.match(regExp);
        if (match && match[7].length === 11) {
            return match[7];
        } else{
            return null;
        }
    };

    this.extractVideoID = function(url){

        var videoData = {};

        if(url.search(/youtu\.?be/i) !== -1){
            videoData.videoID = this.extractYoutubeID(url);
            videoData.videoSource = 'youtube';
        } else if(url.search('vimeo') !== -1){
            videoData.videoID = this.extractVimeoID(url);
            videoData.videoSource = 'vimeo';
        }
        return videoData;
    };

    this.appendVideo = function(element, videoData){
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

        $(element).find('.placeholders i').hide();
        $(element).append($videoIframe);

    };

    this.createVideoSlot = function(elem, name, label) {
        var slot = '<div class="embed-video-wrapper"><div class="form-group text"><label for="video_url">' + label + '</label><span class="remove-video glyphicon glyphicon-remove"></span><input class="form-control embed-video" id="' + name + '" name="' + name + '" type="text" value=""></div><div class="preview-box"><div class="placeholders"><div class="idle glyphicon glyphicon-film"></div><div class="error glyphicon glyphicon-exclamation-sign"></div></div></div></div>';

        return $(elem).append($(slot));

    };
};

var videoManager = new EmbededVideoManager();