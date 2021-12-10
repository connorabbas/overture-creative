<?php
namespace Elementor;

class Overture_Advanced_Lightbox extends Widget_Base {

	public function get_name() {
		return 'advanced-gallery-lightbox';
		//return 'title-subtitle';
	}
	
	public function get_title() {
		return 'Advanced Gallery Lightbox';
	}
	
	public function get_icon() {
		return 'fas fa-th';
	}
	
	public function get_categories() {
		return [ 'overture-creative' ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Content', 'elementor' ),
			]
		);

		$this->add_control(
			'more_options',
			[
				'label' => __( 'This widget requires photoSwipe *', 'elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'grid_gallery',
			[
				'label' => __( 'Add Grid Images', 'elementor' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);
        $this->add_control(
			'popout_gallery',
			[
				'label' => __( 'Add Popout Images', 'elementor' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);
		$this->add_control(
			'aspect_ratio',
			[
				'label' => __( 'Aspect Ratio', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1:1',
				'options' => [
					'1:1'  => __( '1:1', 'plugin-domain' ),
					'3:4' => __( '3:4', 'plugin-domain' ),
					'4:3' => __( '4:3', 'plugin-domain' ),
					'16:9' => __( '16:9', 'plugin-domain' ),
					'21:9' => __( '21:9', 'plugin-domain' ),
				],
			]
		);
		$this->add_control(
			'number_per_row',
			[
				'label' => __( 'Columns', 'elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 4,
			]
		);
		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Image Spacing (px)', 'elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 5,
			]
		);
		$this->add_control(
			'image_box_shadow',
			[
				'label' => __( 'Image Box-Shadow', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'your-plugin' ),
				'label_off' => __( 'Off', 'your-plugin' ),
				'return_value' => 'on',
				'default' => 'on',
			]
		);
		/* $this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				],
				'default' => 'rgba(0,0,0,.8)',
			]
		); */

		$this->end_controls_section();
	}
	
	protected function render() {

		if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			$action = 'editing';
		} else {
			$action = 'not editing';
		}
        $settings = $this->get_settings_for_display();
		$widID = $this->get_id();
		if($settings['number_per_row'] == 1){ $colW = 100; }
		if($settings['number_per_row'] == 2){ $colW = 50; }
		if($settings['number_per_row'] == 3){ $colW = 33.33; }
		if($settings['number_per_row'] == 4){ $colW = 25; }
		if($settings['number_per_row'] == 5){ $colW = 20; }
		if($settings['number_per_row'] == 6){ $colW = 16.6666666667; }
		if($settings['number_per_row'] == 7){ $colW = 14.285714285714285714285714285714; }
		if($settings['number_per_row'] == 8){ $colW = 12.5; }
		if($settings['number_per_row'] == 9){ $colW = 11.1111111; }
		if($settings['number_per_row'] == 10){ $colW = 10; }

		if($settings['aspect_ratio'] == '1:1'){ $dummyHeight = 100; }
		if($settings['aspect_ratio'] == '3:4'){ $dummyHeight = 125; }
		if($settings['aspect_ratio'] == '4:3'){ $dummyHeight = 75; }
		if($settings['aspect_ratio'] == '16:9'){ $dummyHeight = 75; }
		if($settings['aspect_ratio'] == '16:9'){ $dummyHeight = 56.25; }
		if($settings['aspect_ratio'] == '21:9'){ $dummyHeight = 42.857142; }


		$imgSpace = $settings['image_spacing']/2;
		ob_start();
		/* echo '<pre style="max-height:500px; overflow-y: scroll;">';
		var_dump($settings['grid_gallery']);
		echo '</pre>'; */
		?>
		<div id="pswp_widget_<?php echo $widID; ?>" style="width: 100%;">
			<div class="my-gallery_<?php echo $widID; ?>" itemscope itemtype="http://schema.org/ImageGallery">
				<div class="row" style="margin: -<?php echo $imgSpace;?>px !important;">
				<?php
				$imgCount = 0;
				$aosDelay = 250;
				//foreach ( $settings['gallery'] as $image ) {
                for($i=0; $i<count($settings['grid_gallery']); $i++){
					$imgCount++;
                    $popout_id = $settings['grid_gallery'][$i]['id'];
					//$aosDelay = $aosDelay+0;
					$popout_img = wp_get_attachment_image_src( $popout_id , 'full', false);
					$imgURL = $popout_img[0];
					$imgW = $popout_img[1];
					$imgH = $popout_img[2];
					$imgSize = $imgW.'x'.$imgH;
					?>
					<figure class="lightbox_col" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" <?php if($action != 'editing') echo 'data-aos="fade-up"' ?>  data-aos-duration="1000" data-aos-delay="<?php echo $aosDelay;?>">
						<div style="padding:10px !important; position:relative;">
							<a href="<?php echo $settings['popout_gallery'][$i]['url']; ?>" itemprop="contentUrl" data-size="<?php echo $imgSize ; ?>">
								<img src="<?php echo $settings['grid_gallery'][$i]['url']; ?>" itemprop="thumbnail" alt="Image description" />
							</a>
							<div class="dummy_space_<?php echo $widID; ?>"></div>
						</div>
					</figure>
					<?php
					/* if($imgCount % 2 == 0){
						echo '</div><div class="row">';
					} */
				} 
				?>
				</div>
			</div>

			<div id="pswp_controls_<?php echo $widID; ?>" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="pswp__bg" style=""></div>
				<div class="pswp__scroll-wrap">
					<div class="pswp__container">
						<div class="pswp__item"></div>
						<div class="pswp__item"></div>
						<div class="pswp__item"></div>
					</div>
					<div class="pswp__ui pswp__ui--hidden">
						<div class="pswp__top-bar">
							<div class="pswp__counter"></div>
							<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
							<button class="pswp__button pswp__button--share" title="Share"></button>
							<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
							<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
							<div class="pswp__preloader">
								<div class="pswp__preloader__icn">
									<div class="pswp__preloader__cut">
									<div class="pswp__preloader__donut"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
							<div class="pswp__share-tooltip"></div> 
						</div>
						<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
						</button>
						<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
						</button>
						<div class="pswp__caption">
							<div class="pswp__caption__center"></div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		/* #pswp_controls_<?php //echo $widID; ?> .pswp__bg{
			background:<?php //echo $settings['background_color']; ?> !important;
		} */
		.dummy_space_<?php echo $widID; ?> {
			margin-top: 0%;
			margin-top: <?php echo $dummyHeight;?>%;
		}
		.my-gallery_<?php echo $widID; ?> {
			width: 100%;
			float: left;
		}
		.my-gallery_<?php echo $widID; ?> img {
			/* height: 200px; */
			/* object-fit:contain; */
			object-fit:cover;
			position: absolute;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			height: 100%;
			width: 100%;
			<?php
			if($settings['image_box_shadow'] == 'on'){
				echo 'box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;';
			}
			?>
		}
		.my-gallery_<?php echo $widID; ?> img:hover{
			cursor: zoom-in;
		}
		.my-gallery_<?php echo $widID; ?> figure {
			position: relative;
			display: block;
			float: left;
			width:<?php echo $colW; ?>%;
			padding: 0 !important;
			padding: <?php echo $imgSpace; ?>px !important;
			overflow:hidden;
		}
		.my-gallery_<?php echo $widID; ?> figcaption {
			display: none;
		}
		.pswp__img {
			box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
		}
		.pswp__bg{
			background: rgba(0, 0, 0, .8);
		}
		</style>

		<script>
			var initPhotoSwipeFromDOM_<?php echo $widID; ?> = function(gallerySelector) {

				var parseThumbnailElements_<?php echo $widID; ?> = function(el) {
					var thumbElements = el.childNodes,
						numNodes = thumbElements.length,
						items = [],
						figureEl,
						linkEl,
						size,
						item;

					for(var i = 0; i < numNodes; i++) {

						figureEl = thumbElements[i]; 
						if(figureEl.nodeType !== 1) {
							continue;
						}
						// changed becuase extra div added inside figure
						//linkEl = figureEl.children[0];
						linkEl = figureEl.children[0].children[0];
						size = linkEl.getAttribute('data-size').split('x');
						item = {
							src: linkEl.getAttribute('href'),
							w: parseInt(size[0], 10),
							h: parseInt(size[1], 10)
						};
						if(figureEl.children.length > 1) {
							item.title = figureEl.children[1].innerHTML; 
						}
						if(linkEl.children.length > 0) {
							item.msrc = linkEl.children[0].getAttribute('src');
							//item.msrc = linkEl.children[1].getAttribute('src');
						} 
						item.el = figureEl;
						items.push(item);
					}

					return items;
				};

				var closest_<?php echo $widID; ?> = function closest_<?php echo $widID; ?>(el, fn) {
					return el && ( fn(el) ? el : closest_<?php echo $widID; ?>(el.parentNode, fn) );
				};

				var onThumbnailsClick_<?php echo $widID; ?> = function(e) {
					e = e || window.event;
					e.preventDefault ? e.preventDefault() : e.returnValue = false;
					var eTarget = e.target || e.srcElement;
					var clickedListItem = closest_<?php echo $widID; ?>(eTarget, function(el) {
						return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
					});
					if(!clickedListItem) {
						return;
					}
					var clickedGallery = clickedListItem.parentNode,
						childNodes = clickedListItem.parentNode.childNodes,
						numChildNodes = childNodes.length,
						nodeIndex = 0,
						index;
					for (var i = 0; i < numChildNodes; i++) {
						if(childNodes[i].nodeType !== 1) { 
							continue; 
						}
						if(childNodes[i] === clickedListItem) {
							index = nodeIndex;
							break;
						}
						nodeIndex++;
					}

					if(index >= 0) {
						openPhotoSwipe_<?php echo $widID; ?>( index, clickedGallery );
					}
					return false;
				};

				var photoswipeParseHash_<?php echo $widID; ?> = function() {
					var hash = window.location.hash.substring(1),
					params = {};
					if(hash.length < 5) {
						return params;
					}
					var vars = hash.split('&');
					for (var i = 0; i < vars.length; i++) {
						if(!vars[i]) {
							continue;
						}
						var pair = vars[i].split('=');  
						if(pair.length < 2) {
							continue;
						}           
						params[pair[0]] = pair[1];
					}
					if(params.gid) {
						params.gid = parseInt(params.gid, 10);
					}
					return params;
				};

				var openPhotoSwipe_<?php echo $widID; ?> = function(index, galleryElement, disableAnimation, fromURL) {
					var pswpElement = document.querySelectorAll('.pswp')[0],
						gallery,
						options,
						items;
					items = parseThumbnailElements_<?php echo $widID; ?>(galleryElement);
					options = {
						galleryUID: galleryElement.getAttribute('data-pswp-uid'),
						getThumbBoundsFn: function(index) {
							var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
								pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
								rect = thumbnail.getBoundingClientRect(); 

							return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
						}

					};
					if(fromURL) {
						if(options.galleryPIDs) {
							for(var j = 0; j < items.length; j++) {
								if(items[j].pid == index) {
									options.index = j;
									break;
								}
							}
						} else {
							options.index = parseInt(index, 10) - 1;
						}
					} else {
						options.index = parseInt(index, 10);
					}
					if( isNaN(options.index) ) {
						return;
					}
					if(disableAnimation) {
						options.showAnimationDuration = 0;
					}
					gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
					gallery.init();
				};

				var galleryElements_<?php echo $widID; ?> = document.querySelectorAll( gallerySelector );
				for(var i = 0, l = galleryElements_<?php echo $widID; ?>.length; i < l; i++) {
					galleryElements_<?php echo $widID; ?>[i].setAttribute('data-pswp-uid', i+1);
					galleryElements_<?php echo $widID; ?>[i].onclick = onThumbnailsClick_<?php echo $widID; ?>;
				}

				var hashData = photoswipeParseHash_<?php echo $widID; ?>();
				if(hashData.pid && hashData.gid) {
					openPhotoSwipe_<?php echo $widID; ?>( hashData.pid ,  galleryElements_<?php echo $widID; ?>[ hashData.gid - 1 ], true, true );
				}
			};

			initPhotoSwipeFromDOM_<?php echo $widID; ?>('.my-gallery_<?php echo $widID; ?>');
		
		</script>
		<?php
		$html = ob_get_clean();
		echo $html;
		/* echo '<pre style="max-height:500px; overflow-y: scroll;">';
		var_dump($psScript);
		echo '</pre>'; */

	}
	
	protected function _content_template() {

    }
	
	
}