$(window).addEvent('domready', function() {
	var toggler = $$('span.toggle_comments');
	var accordions = $$('div.task_comments');
    if (toggler.length && toggler.length == accordions.length) {
        new Fx.Accordion(toggler, accordions, {
            display: -1,
            alwaysHide: true,
            onActive: function(toggler, element) {
                var img = $(toggler).getElement('img');
                img.src = img.src.replace(/folPlus\.gif/, 'folMinus.gif');
            },
            onBackground: function(toggler, element) {
                var img = $(toggler).getElement('img');
                img.src = img.src.replace(/folMinus\.gif/, 'folPlus.gif');
            }
		});
	}
});

function moreComments(id) {
	var link = $('more_comments_' + id);
	var countElement = link.getParent();
	var comments = $('comments_' + id);
	var offset = parseInt(comments.getProperty('data-offset'));
	var count = parseInt(comments.getProperty('data-count'));

	new Request.Contao({
	    onSuccess: function(html, json) {
		    new Element('div').set('html', html).getChildren().each(function(child) {
			    child.inject(countElement, 'before');
		    });

		    if (offset+3 >= count) {
			    link.destroy();
		    } else {
			    comments.setProperty('data-offset', offset+3);
		    }
	    }
	}).post({
		'pid': id,
		'offset': offset,
		'action': 'moreComments',
		'REQUEST_TOKEN': Contao.request_token
	});
}