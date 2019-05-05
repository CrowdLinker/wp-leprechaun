import {fabric} from 'fabric'
import PostName from './variable-tags/post-name'

(function( $ ) {
	'use strict';

	$( window ).load(function() {

		const canvas = new fabric.Canvas('wp-leprechaun-canvas');
		const input = $('[name="wp_lp_template_canvas"]');

		// Decode value
		if(input.val()) {
			const decoded = decodeURIComponent(input.val());
			canvas.loadFromDatalessJSON(decoded, () => {
				console.log('Loaded')
			});
		}
		

		canvas.on('mouse:wheel', function(opt) {
			var delta = opt.e.deltaY;
			var zoom = canvas.getZoom();
			zoom = zoom + delta/200;
			if (zoom > 10) zoom = 10;
			if (zoom < 1) zoom = 1;
			canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
			opt.e.preventDefault();
			opt.e.stopPropagation();
			var vpt = this.viewportTransform;
			if (zoom < 400 / 1000) {
			  this.viewportTransform[4] = 200 - 1000 * zoom / 2;
			  this.viewportTransform[5] = 200 - 1000 * zoom / 2;
			} else {
				if (vpt[4] >= 0) {
				this.viewportTransform[4] = 0;
				} else if (vpt[4] < canvas.getWidth() - 1000 * zoom) {
				this.viewportTransform[4] = canvas.getWidth() - 1000 * zoom;
				}
				if (vpt[5] >= 0) {
				this.viewportTransform[5] = 0;
				} else if (vpt[5] < canvas.getHeight() - 1000 * zoom) {
				this.viewportTransform[5] = canvas.getHeight() - 1000 * zoom;
				}
			}
		})

		const rect = new fabric.Rect({
			left: 100,
			top: 100,
			fill: 'red',
			width: 20,
			height: 20,
			angle: 45
		});

		canvas.add(rect);

		const postName = new PostName({
			width: 100,
			height: 35,
			left: 100,
			top: 100,
			fill: '#faa'
		});

		canvas.add(postName);

		// Encode object
		$( '#post' ).submit( function( e ) {
			input.val(JSON.stringify(canvas.toDatalessJSON()));
		} );
	});

})( jQuery );
