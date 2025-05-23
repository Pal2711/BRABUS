/*Butterbean fields*/
( function($) {

   $(document).ready(function() {
    var hiddenInput = $('.butterbean-content input[type="hidden"][data-section-id]');
    });

    $('body').on('click','.stm_vehicles_listing_icons .inner .stm_font_nav a',function(e){
        e.preventDefault();
        $('.stm_vehicles_listing_icons .inner .stm_font_nav a').removeClass('active');
        $(this).addClass('active');
        var tabId = $(this).attr('href');
        $('.stm_theme_font').removeClass('active');
        $(tabId).addClass('active');
    });

    /*Open/Delete icons*/
    $(document).on('click', '.stm_info_group_icon .stm_delete_icon', function(e){
        $(this).parent().find('input').val('').trigger('change');
        $(this).parent().find('i').removeAttr('class').attr('class', 'hidden');
    });

    var currentTarget = '';
    $(document).on('click', '.stm_info_group_icon .icon', function(e){
        e.preventDefault();
        currentTarget = $(this).parent();

        $('.stm_vehicles_listing_icons').addClass('visible');
        $('.stm-listings-pick-icon').removeClass('chosen');
        $('.stm_vehicles_listing_icons').closest('.stm-listings-pick-icon').addClass('chosen');
    });

    $('body').on('click', '.stm_vehicles_listing_icons .inner td.stm-listings-pick-icon i', function(){
        var stmClass = $(this).attr('class').replace(' big_icon', '');
        currentTarget.find('input').val(stmClass).trigger('change');
        currentTarget.find('.icon i').removeClass('hidden').attr('class', stmClass);

        currentTarget.find('.stm_info_group_icon').addClass('stm_icon_given');

        stm_listings_close_icons();
    });

    $('body').on('click', '.stm_vehicles_listing_icons .overlay', function(){
        $('.stm_vehicles_listing_icons').removeClass('visible');
    });

    function stm_listings_close_icons() {
        $('.stm_vehicles_listing_icons').removeClass('visible');
    }

    function filterAddressComponents(place) {
        let items = '';

        if ( place && typeof(place.address_components) !== "undefined" ) {
            let address = place.address_components.length > 0 ? place.address_components : false;

            if ( address && Array.isArray( address ) ) {
                items = [];

                address.forEach(
                    function (item) {
                        let types = ['country', 'locality', 'sublocality_level_1', 'administrative_area_level_1', 'route'];

                        let findType = item.types.find(
                            function ( type ) {
                                return types.includes( type );
                            }
                        );

                        if ( findType !== undefined ) {
                            let uniqItem = {
                                key: findType,
                                value: item.long_name
                            };

                            items.push( uniqItem );
                        }
                    }
                );

                if ( items ) {
                    items = JSON.stringify( items );
                } else {
                    items = '';
                }
            }
        }

        return items;
    }

    /*Multiselect*/
    butterbean.views.register_control('multiselect', {
        events: {
            'keydown .stm-multiselect-wrapper .stm_add_new_optionale input': 'preventsubmit',
            'click .stm-multiselect-wrapper .fa-plus': 'addfield',
            'click .stm-multiselect-wrapper .stm_add_new_optionale .stm_add_new_btn': 'addfield',
            'change': 'beforeChange',
        },

        ready: function() {
            var $select = jQuery(this.el).find('select');
            $select.select2({
                width: '100%',
                dropdownParent: jQuery('body'),
                tags: true,
                placeholder: this.model.get('l10n').field_placeholder,
                dropdownPosition: 'below',
            })

            $select.on('select2:open', () => {
                if (jQuery('#butterbean-stm_product_manager-section-stm_info').length) {
                    return;
                }
                let $dropdown = jQuery('.select2-dropdown');

                if (!$dropdown.find('.stm-add-new-wrapper').length) {
                    $dropdown.append(`
                        <div class="stm-add-new-wrapper">
                            <input type="text" class="stm-add-new-input" placeholder="${this.model.get('l10n').add_new}" />
                            <span class="icon-plus stm-add-new-btn">+</span>
                        </div>
                    `)

                    jQuery('.stm-add-new-btn').on('click', (e) => {
                        e.preventDefault();
                        let inputVal = jQuery('.stm-add-new-input').val().trim();

                        if (inputVal !== '') {
                            this.addfield(e, inputVal);
                        }
                    });
                    jQuery('.stm-add-new-input').on('keypress', (e) => {
                        if (e.which === 13) {
                            e.preventDefault();
                            let inputVal = jQuery('.stm-add-new-input').val().trim();

                            if (inputVal !== '') {
                                this.addfield(e, inputVal);
                            }
                        }
                    });
                }
            });
        },

        beforeChange: function(event) {
            var select = jQuery(this.el).find('select');
            var parent = select.attr('data-parent');
            if (!parent || parent.length <= 0) {
                return false;
            }
            var parentVal = jQuery('#butterbean-control-' + parent).find('select').val();
            var name = select.attr('name').replace(/[\])}[{(]/g, '');
            const el = document.createElement('input');
            el.type = 'hidden';
            el.name = name + '_stm_have_parent';
            el.value = parentVal;
            event.currentTarget.appendChild(el);
        },

        preventsubmit: function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                this.addfield(event);

                jQuery('.stm_checkbox_adder').focus();

                return false;
            }
        },

        addfield: function(event, customValue = null) {
            var $ = jQuery;
            var $input = customValue
                ? jQuery('<input>').val(customValue)
                : $(event.currentTarget).closest('.stm_add_new_inner').find('input');
            var inputVal = $input.val();
            var $preloader = $input.closest('.stm_add_new_inner').find('i');

            var select = jQuery(this.el).find('select');
            var parent = select.attr('data-parent');
            var parentVal = '';
            if (typeof parent !== 'undefined' && parent !== null && parent.length > 0) {
                parentVal = jQuery('#butterbean-control-' + parent).find('select').val();
            }

            if (inputVal !== '') {
                $.ajax({
                    url: ajaxurl,
                    dataType: 'json',
                    context: this,
                    data: 'term=' + inputVal + '&category=' + this.model.attributes.name + '&action=stm_listings_add_category_in&stm_parent=' + parentVal + '&security=' + listings_add_category_in,
                    beforeSend: function() {
                        $input.closest('.stm-multiselect-wrapper').addClass('stm_loading');
                        if ($preloader.length) $preloader.addClass('fa-pulse fa-spinner');
                    },
                    complete: $.proxy(function(data) {
                        data = data.responseJSON;
                        $input.closest('.stm-multiselect-wrapper').removeClass('stm_loading');
                        if ($preloader.length) $preloader.removeClass('fa-pulse fa-spinner');

                        var newOption = new Option(data.name, data.slug, true, true);
                        select.append(newOption).trigger('change');

                        if (!customValue) $input.val('');
                        $input.focus();
                        let inputVal = jQuery('.stm-add-new-input').val().trim();

                        if (inputVal !== '') {
                            jQuery('.stm-add-new-input').val('');
                        }

                        select.select2('close');
                    }),
                });
            }
        }
    });

    /*Repeater checks*/
    butterbean.views.register_control( 'checkbox_repeater', {

        // Adds custom events.
        events : {
            'click .butterbean-add-checkbox'    : 'addfield',
            'click .stm_repeater_checkbox .fa-remove'    : 'deletefield',
            'click .stm_repeater_checkboxes input'    : 'changedata',
            'keydown .stm_checkbox_adder' : 'preventsubmit'
        },

        preventsubmit: function(e) {
            if( (event.keyCode == 13) ) {
                event.preventDefault();
                this.addfield(e);

                jQuery('.stm_checkbox_adder').focus();

                return false;
            }
        },

        updatemodel: function() {
            var currentValues = this.model.attributes.values;
            var value = [];

            _.each(currentValues, function(check){
                if(check['checked']) {
                    value.push(check.val);
                }
            });

            this.model.set({
                value: value.join()
            }).trigger( 'change', this.model );
        },

        changedata : function(m) {
            var $ = jQuery;
            var $addC = $(m.currentTarget);
            var currentValues = this.model.attributes.values;
            var currentValue = $addC.prop('checked');
            var currentKey = $addC.data('key');

            currentValues[currentKey]['checked'] = currentValue;

            this.updatemodel();
        },

        addfield : function(m) {
            var $ = jQuery;
            var $addB = $(m.currentTarget);
            var currentValues = this.model.attributes.values;

            var currentValue = $addB.closest('.stm_checkbox_repeater').find('.stm_checkbox_adder').val();

            if(currentValue !== '') {
                currentValues.unshift({
                    val : currentValue,
                    checked : true
                })
            }

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
            this.updatemodel();
        },

        deletefield : function(m) {
            var index = m.currentTarget.dataset.key;

            var currentValues = this.model.attributes.values;

            currentValues.splice(index, 1);

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );

            this.updatemodel();
        }

    } );

    /*Grouped checkboxes*/
    butterbean.views.register_control( 'grouped_checkboxes', {

        // Adds custom events.
        events : {
            'click .butterbean-add-checkbox'    : 'addfield',
            'click .stm_repeater_checkbox .fa-remove'    : 'deletefield',
            'click .grouped_checkboxes_wrap input'    : 'changedata',
            'keydown .stm_checkbox_adder' : 'preventsubmit'
        },

        preventsubmit: function(e) {
            if( (event.keyCode == 13) ) {
                event.preventDefault();
                this.addfield(e);

                jQuery('.stm_checkbox_adder').focus();

                return false;
            }
        },

        updatemodel: function() {
            var currentValues = this.model.attributes.values;
            var value = [];

            _.each(currentValues, function(check){
                _.each(check['group_features'], function(check2){
                    if(check2['checked']) {
                        value.push(check2.val);
                    }
                });
            });

            this.model.set({
                value: value.join()
            }).trigger( 'change', this.model );
        },

        changedata : function(m) {
            var $ = jQuery;
            var $addC = $(m.currentTarget);
            var currentValues = this.model.attributes.values;
            var currentValue = $addC.prop('checked');
            var currentKey = $addC.data('key').split('-');

            currentValues[currentKey[0]]['group_features'][currentKey[1]]['checked'] = currentValue;

            this.updatemodel();
        },

        addfield : function(m) {
            var $ = jQuery;
            var $addB = $(m.currentTarget);
            var currentValues = this.model.attributes.values;

            var currentValue = $addB.closest('.stm_checkbox_repeater').find('.stm_checkbox_adder').val();

            if(currentValue !== '') {
                currentValues.unshift({
                    val : currentValue,
                    checked : true
                })
            }

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
            this.updatemodel();
        },

        deletefield : function(m) {
            var index = m.currentTarget.dataset.key;

            var currentValues = this.model.attributes.values;

            currentValues.splice(index, 1);

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );

            this.updatemodel();
        }

    } );

    /*Repeater*/
    butterbean.views.register_control( 'repeater', {

        // Adds custom events.
        events : {
            'click .butterbean-add-field'    : 'addfield',
            'click .butterbean-delete-field'    : 'deletefield',
            'change .stm_repeater_inputs input' : 'valueadded'
        },

        valueadded: function(m) {
            var $ = jQuery;
            var key = m.currentTarget.dataset.key;
            var value = $(m.currentTarget).val();
            var currentValues = this.model.attributes.values;
            currentValues[key] = value;

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        addfield : function() {
            var currentValues = this.model.attributes.values;
            currentValues.push('');
            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        deletefield : function(m) {
            var index = m.currentTarget.dataset.delete;

            var currentValues = this.model.attributes.values;

            currentValues.splice(index, 1);

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        }

    } );

    /* Video repeater */
    butterbean.views.register_control('video_repeater', {
			events: {
				'click .butterbean-add-field': 'addfield',
				'click .butterbean-delete-field': 'deletefield',
				'change .video-repeater input[name="video_links[]"]': 'valueadded',
				'click .select-image-button': 'selectImage',
				'click .video-repeater .butterbean-remove-media': 'removeImage',
				'click .video-repeater .butterbean-change-media': 'changeImage',
			},

			valueadded: function (m) {
				var $ = jQuery
				var key = m.currentTarget.dataset.key
				var value = $(m.currentTarget).val()
				var currentValues = this.model.attributes.values
				currentValues[key]['link'] = value
				this.model
					.set({
						values: currentValues,
					})
					.trigger('change', this.model)
			},

			addfield: function () {
				var currentValues = this.model.attributes.values
				currentValues.push({ link: '', img: '' })
				this.model
					.set({
						values: currentValues,
					})
					.trigger('change', this.model)
			},

			deletefield: function (m) {
				var index = m.currentTarget.dataset.delete
				var currentValues = this.model.attributes.values

				currentValues.splice(index, 1)

				this.model
					.set({
						values: currentValues,
					})
					.trigger('change', this.model)
			},

			selectImage: function (m) {
				var self = this
				var hiddenInput = jQuery(this.el).find('input[name="video_image[]"]')

				var frame = wp.media({
					title: 'Choose image',
					button: { text: 'Choose image' },
					multiple: false,
				})

				var $ = jQuery
				var key = m.currentTarget.dataset.key
				var value_img = $(m.currentTarget).val()

				frame.on('select', function (m) {
					var attachment = frame.state().get('selection').first().toJSON()
					hiddenInput.val(attachment.id)

					var currentValues = self.model.attributes.values
					currentValues[key]['img'] = attachment.id
					currentValues[key]['img_url'] = attachment.url
					self.model
						.set({
							values: currentValues,
						})
						.trigger('change', self.model)
				})

				frame.open()
			},

			removeImage: function (m) {
				var self = this
				var key = m.currentTarget.dataset.key
				var currentValues = self.model.attributes.values

				currentValues[key]['img'] = ''
				currentValues[key]['img_url'] = ''
				this.model
					.set({
						values: currentValues,
					})
					.trigger('change', this.model)
			},

			changeImage: function (m) {
				var self = this
				var hiddenInput = jQuery(this.el).find('input[name="video_image[]"]')

				var frame = wp.media({
					title: 'Choose image',
					button: { text: 'Choose image' },
					multiple: false,
				})

				var $ = jQuery
				var key = m.currentTarget.dataset.key
				var value_img = $(m.currentTarget).val()

				frame.on('select', function (m) {
					var attachment = frame.state().get('selection').first().toJSON()
					hiddenInput.val(attachment.id)

					var currentValues = self.model.attributes.values
					currentValues[key]['img'] = attachment.id
					currentValues[key]['img_url'] = attachment.url
					self.model
						.set({
							values: currentValues,
						})
						.trigger('change', self.model)
				})

				frame.open()
			},
		})

    /*Media repeater*/
    butterbean.views.register_control('media_repeater', {
			events: {
				'click .butterbean-add-field': 'addfield',
				'click .butterbean-delete-field': 'deletefield',
				'change .media-repeater input[name="certificate_media_links[]"]': 'valueadded',
				'click .select-image-button': 'selectImage',
				'click .media-repeater .butterbean-remove-media': 'removeImage',
				'click .media-repeater .butterbean-change-media': 'changeImage',
				'change .media-repeater input[name="certificate_media_file_name[]"]': 'fileNameAdded',
			},

			valueadded: function (m) {
				var $ = jQuery
				var key = m.currentTarget.dataset.key
				var value = $(m.currentTarget).val()
				var currentValues = this.model.attributes.values
				currentValues[key]['media_link'] = value
				this.model
					.set({
						values: currentValues,
					})
					.trigger('change', this.model)
			},

			fileNameAdded: function (m) {
				var $ = jQuery
				var key = m.currentTarget.dataset.key
				var value = $(m.currentTarget).val()
				var currentValues = this.model.attributes.values
				currentValues[key]['media_file_name'] = value
				this.model.set({ values: currentValues }).trigger('change', this.model)
			},

			addfield: function () {
				var currentValues = this.model.attributes.values
				if (currentValues.length < 2) {
					currentValues.push({ media_link: '', media_img: '', media_file_name: '' })
					this.model
						.set({
							values: currentValues,
						})
						.trigger('change', this.model)
				}
                if (currentValues.length >= 2) {
					jQuery('.butterbean-add-field.add-media-repeater').hide()
				}
			},

			deletefield: function (m) {
				var index = m.currentTarget.dataset.delete
				var currentValues = this.model.attributes.values

				currentValues.splice(index, 1)

				this.model
					.set({
						values: currentValues,
					})
					.trigger('change', this.model)
			},

			selectImage: function (m) {
				var self = this
				var hiddenInput = jQuery(this.el).find('input[name="certificate_media_image[]"]')

				var frame = wp.media({
					title: 'Choose image',
					button: { text: 'Choose image' },
					multiple: false,
				})

				var $ = jQuery
				var key = m.currentTarget.dataset.key
				var value_img = $(m.currentTarget).val()

				frame.on('select', function (m) {
					var attachment = frame.state().get('selection').first().toJSON()
					hiddenInput.val(attachment.id)

					var currentValues = self.model.attributes.values
					currentValues[key]['media_img'] = attachment.id
					currentValues[key]['media_img_url'] = attachment.url
					self.model
						.set({
							values: currentValues,
						})
						.trigger('change', self.model)
				})

				frame.open()
			},

			removeImage: function (m) {
				var self = this
				var key = m.currentTarget.dataset.key
				var currentValues = self.model.attributes.values

				currentValues[key]['media_img'] = ''
				currentValues[key]['media_img_url'] = ''
				this.model
					.set({
						values: currentValues,
					})
					.trigger('change', self.model)
			},

			changeImage: function (m) {
				var self = this
				var hiddenInput = jQuery(this.el).find('input[name="certificate_media_image[]"]')

				var frame = wp.media({
					title: 'Choose image',
					button: { text: 'Choose image' },
					multiple: false,
				})

				var $ = jQuery
				var key = m.currentTarget.dataset.key
				var value_img = $(m.currentTarget).val()

				frame.on('select', function (m) {
					var attachment = frame.state().get('selection').first().toJSON()
					hiddenInput.val(attachment.id)

					var currentValues = self.model.attributes.values
					currentValues[key]['media_img'] = attachment.id
					currentValues[key]['media_img_url'] = attachment.url
					self.model
						.set({
							values: currentValues,
						})
						.trigger('change', self.model)
				})

				frame.open()
			},
		})

    /*Repeater Info*/
    butterbean.views.register_control( 'repeater-info', {

        // Adds custom events.
        events : {
            'click .butterbean-add-info-group'    : 'addgroup',
            'click .butterbean-remove-group'    : 'deletegroup',
            'click .butterbean-add-info-field'    : 'addfield',
            'click .butterbean-delete-info-field'    : 'deletefield',
            'click .butterbean-move-group-up'    : 'moveup',
            'click .butterbean-move-group-down'    : 'movedown',
            'change .stm_repeater_info_inputs input' : 'valueadded',
            'change .stm_info_group_icon input' : 'chooseicon',
            'change .group-title-input input' : 'addtitle',
        },

        moveup: function(m) {
            var gkey = m.currentTarget.dataset.gkey
            var currentValues = this.model.attributes.values;
            const groupItem = currentValues[gkey];
            currentValues.splice(gkey, 1);
            currentValues.splice(gkey - 1, 0, groupItem);

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        movedown: function(m) {
            var gkey = m.currentTarget.dataset.gkey
            var currentValues = this.model.attributes.values;
            const groupItem = currentValues[gkey];
            currentValues.splice(gkey, 1);
            currentValues.splice(gkey + 1, 0, groupItem);

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        addtitle: function(m) {
            var $ = jQuery;
            var gkey = m.currentTarget.dataset.gkey;
            var value = $(m.currentTarget).val();
            var currentValues = this.model.attributes.values;
            currentValues[gkey].main_title = value;

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        chooseicon: function(m) {
            var $ = jQuery;
            var gkey = m.currentTarget.dataset.gkey;
            var value = $(m.currentTarget).val();

            var currentValues = this.model.attributes.values;
            currentValues[gkey].icon = value;

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        addgroup: function() {
            var currentValues = this.model.attributes.values;

            currentValues.push({main_title: '', icon: '', fields: [{item_title: '', item_val: ''}]});

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        valueadded: function(m) {
            var $ = jQuery;
            var key = m.currentTarget.dataset.key;
            var gkey = m.currentTarget.dataset.gkey;
            var value = $(m.currentTarget).val();
            var type = m.currentTarget.dataset.name;
            var currentValues = this.model.attributes.values;
            if(type == 'k') currentValues[gkey].fields[key]['item_title'] = value;
            if(type == 'v') currentValues[gkey].fields[key]['item_val'] = value;

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        addfield : function(m) {
            var key = m.currentTarget.dataset.key;
            var currentValues = this.model.attributes.values;

            currentValues[key].fields.push({item_title: '', item_val: ''});
            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        deletefield : function(m) {
            var group = m.currentTarget.dataset.group;
            var index = m.currentTarget.dataset.delete;

            var currentValues = this.model.attributes.values;

            currentValues[group].fields.splice(index, 1);

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        },

        deletegroup : function(m) {
            var group = m.currentTarget.dataset.gkey;

            var currentValues = this.model.attributes.values;

            currentValues.splice(group, 1);

            this.model.set({
                values: currentValues
            }).trigger( 'change', this.model );
        }

    } );

    /*File*/
    butterbean.views.register_control( 'file', {

        // Adds custom events.
        events : {
            'click .butterbean-add-media'    : 'showmodal',
            'click .butterbean-change-media' : 'showmodal',
            'click .butterbean-remove-media' : 'removemedia'
        },

        // Executed when the show modal button is clicked.
        showmodal : function() {


            // If we already have a media modal, open it.
            if ( ! _.isUndefined( this.media_modal ) ) {

                this.media_modal.open();
                return;
            }

            // Create a new media modal.
            var format = this.model.attributes.format;

            this.media_modal = wp.media( {
                frame    : 'select',
                multiple : false,
                editing  : true,
                title    : this.model.get( 'l10n' ).choose,
                library  : { type : format },
                button   : { text:  this.model.get( 'l10n' ).set }
            } );

            // Runs when an image is selected in the media modal.
            this.media_modal.on( 'select', function() {

                // Gets the JSON data for the first selection.
                var media = this.media_modal.state().get( 'selection' ).first().toJSON();

                // Updates the model for the view.
                this.model.set( {
                    src   : media.filename,
                    value : media.id
                } );

            }, this );

            // Opens the media modal.
            this.media_modal.open();
        },

        // Executed when the remove media button is clicked.
        removemedia : function() {

            // Updates the model for the view.
            this.model.set( { src : '', value : '' } );
        }
    } );

    /*Datepicker*/
    butterbean.views.register_control( 'datepicker', {
        events : {
            'click .butterbean-datepicker': 'initDatepicker',
        },

        ready: function(){
            jQuery( '.butterbean-datepicker' ).datepicker({
                dateFormat: "d/m/yy"
            });
        },

        initDatepicker: function(m){
            jQuery( m.currentTarget ).datepicker();
        }
    } );

    /*Gallery*/
    butterbean.views.register_control( 'gallery', {

        // Adds custom events.
        events : {
            'click .butterbean-add-media'    : 'showmodal',
            'click .butterbean-change-media' : 'showmodal',
            'click .butterbean-remove-media' : 'removemedia',
            'click .stm_mini_thumbs .thumbs .fa-times' : 'removemedia_single'
        },

        // Executed when the show modal button is clicked.
        showmodal : function() {


            // If we already have a media modal, open it.
            if ( ! _.isUndefined( this.media_modal ) ) {

                this.media_modal.open();
                return;
            }

            // Create a new media modal.
            this.media_modal = wp.media( {
                frame    : 'select',
                multiple : true,
                editing  : true,
                title    : this.model.get( 'l10n' ).choose,
                library  : { type : 'image' },
                button   : { text:  this.model.get( 'l10n' ).set }
            } );

            // Runs when an image is selected in the media modal.
            this.media_modal.on( 'select', function() {

                // Gets the JSON data for the first selection.
                var media = this.media_modal.state().get( 'selection' ).toJSON();

                var size = this.model.attributes.size;

                var medias = this.model.attributes.values;
                var ids = this.model.attributes.value.split(',');

                _.each(media, function(img){
                    ids.push(img.id);
                    medias.push({
                        id: img.id,
                        src: img.sizes[size] ? img.sizes[size]['url'] : img.url,
                        thumb: img.sizes['stm-img-350-205'] ? img.sizes['stm-img-350-205']['url'] : img.url,
                    })
                });

                this.model.set(medias);
                this.model.set({
                    value: ids.join()
                });

            }, this );

            // Opens the media modal.
            this.media_modal.open();
        },

        // Executed when the remove media button is clicked.
        removemedia : function() {

            this.model.set({
                value: '',
                values: []
            });

        },

        removemedia_single : function(m) {

            var index = m.currentTarget.dataset.delete;

            var medias = this.model.attributes.values;
            var ids = this.model.attributes.value.split(',');

            if(typeof medias[index] !== 'undefined' && typeof ids[index] !== 'undefined') {
                medias.splice(index, 1);
                ids.splice(index, 1);
            }

            this.model.set(medias);
            this.model.set({
                value: ids.join()
            });

            // empty gallery if last element has been deleted
            if(medias.length == 0) {
                this.removemedia();
            }

        },

        initSwap: function() {
            var $ = jQuery;

            var medias = this.model.attributes.values;

            var moduleId = '#butterbean-control-' + this.model.attributes.name + ' ';

            $(moduleId + '.stm_mini_thumbs .thumbs .featured-item').remove();

            if (medias.length > 0) {
                var firstThumb = $(moduleId + '.stm_mini_thumbs .thumbs .inner').first();
                if (!firstThumb.find('.featured-item').length) {
                    firstThumb.append(`<span class="featured-item">${this.model.get('l10n').featured}</span>`);
                }
            }

            $(document).on("mouseenter", moduleId + '.stm_mini_thumbs .thumbs .inner', function(e) {
                var item = $(this);
                item.draggable({
                    revert: 'invalid',
                    helper: "clone",
                    start: function() {
                        item.closest('.thumbs').addClass('main-target');
                        $(moduleId + '.main_image .main_image_droppable').addClass('drop-here');
                    },
                    stop: function() {
                        item.closest('.thumbs').addClass('main-target');
                        $(moduleId + '.main_image .main_image_droppable').removeClass('drop-here');
                    }
                });
            });

            $(moduleId + '.stm_mini_thumbs .thumbs').droppable({
                drop: $.proxy(stmDroppableEvent, this),
            });

            $(moduleId + '.main_image').droppable({
                drop: $.proxy(stmDropFeatured, this),
            });

            $(moduleId + ".stm_mini_thumbs .thumbs").on("dropover", function(event, ui) {
                $(event.target).addClass('targets-here');
            });

            $(moduleId + ".stm_mini_thumbs .thumbs").on("dropout", function(event, ui) {
                $(event.target).removeClass('targets-here');
            });

            function stmDropFeatured(event, ui) {
                var ids = [];

                var dragFromIndex = ui.draggable[0].dataset.thumb;
                var dragToIndex = 0;

                var swapFrom = medias[dragFromIndex];
                var swapTo = medias[dragToIndex];

                medias[dragToIndex] = swapFrom;
                medias[dragFromIndex] = swapTo;

                _.each(medias, function(img) {
                    ids.push(img.id);
                });

                this.model.set({
                    values: medias,
                    value: ids.join()
                });

                $(moduleId + '.stm_mini_thumbs .thumbs').removeClass('targets-here main-target');

                $(moduleId + '.main_image .main_image_droppable').removeClass('drop-here');
            }

            function stmDroppableEvent(event, ui) {
                var ids = [];

                var dragFromIndex = ui.draggable[0].dataset.thumb;
                var dragToIndex = $(event.target).find('.inner').data('thumb');

                var swapFrom = medias[dragFromIndex];
                var swapTo = medias[dragToIndex];

                medias[dragToIndex] = swapFrom;
                medias[dragFromIndex] = swapTo;

                _.each(medias, function(img) {
                    ids.push(img.id);
                });

                this.model.set({
                    values: medias,
                    value: ids.join()
                });
            }
        },

        ready: function(){
            this.model.on( 'change', this.onchange, this );
            this.initSwap()
        },

        onchange: function(){
            this.initSwap()
        }

    } );

} )(jQuery);

(function($) {

    $(document).ready(function () {
        var elements = '.stm_checkbox_adder,' +
            '.butterbean-datepicker,' +
            'select,input[type="text"].widefat,' +
            '.stm_repeater_inputs input[type="text"]';
        $(elements).each(function () {
            if ($(this).val()) {
                $(this).addClass('has-value');
            }
            $(document).on('change', elements, function () {
                if ($(this).val()) {
                    $(this).addClass('has-value');
                } else {
                    $(this).removeClass('has-value');
                }
            })
        });


        /*PREVIEW*/
        $(document).on('click', '.image_preview', function(){
            var stmImage = $(this).find('span').data('preview');
            $('#wpfooter').append('<div class="image-preview visible"><div class="overlay"></div><img src="' + stmImage + '" /></div>');
            $('#ui-datepicker-div').css('display', 'none');
        });

        $(document).on('click', '.image-preview .overlay', function(){
            $('.image-preview').removeClass('visible').remove();
        });

        /*Reset amount*/
        $(document).on('click', '.reset_field', function(e){
            e.preventDefault();

            if($(this).data('type') == 'stm_car_views') {
                $('input[name="butterbean_stm_car_manager_setting_stm_car_views"]').val('');
            } else if($(this).data('type') == 'stm_phone_reveals') {
                $('input[name="butterbean_stm_car_manager_setting_stm_phone_reveals"]').val('');
            }
        });

        $('input[name="butterbean_stm_car_manager_setting_car_mark_woo_online"]').on('change', function(){
            $('input[name="butterbean_stm_car_manager_setting_stm_car_stock"]').val(1);
        });

        $('input[name="butterbean_stm_car_manager_setting_car_mark_as_sold"]').on('change', function(){
            if($(this).is(':checked')) {
                $('input[name="butterbean_stm_car_manager_setting_stm_car_stock"]').val(1);
                $('input[name="butterbean_stm_car_manager_setting_car_mark_woo_online"]').prop('checked', false);
                $('#butterbean-control-stm_car_stock').hide();
            }
        });
    });

    $(window).load(function(){

        $('[data-dep]').each(function(){
            var $stmThis = $(this);

            var managerName = 'stm_car_manager_setting_';

            var elementDepended = $stmThis.data('dep');

            $(document).on('change', 'input[name="butterbean_' + managerName + elementDepended + '"]', function(){
                stmHideUseless(managerName, elementDepended, $stmThis);
            });

            stmHideUseless(managerName, elementDepended, $stmThis);
        });

        // compatibility for multilisting
        // are we on multilisting type edit/add screen?
        if ( typeof multilisting_current_type_admin_js !== 'undefined' && multilisting_current_type_admin_js != 'listings' ) {
            // do we have any multilisting types registred?
            if ( typeof multilisting_types_admin_js !== 'undefined' && multilisting_types_admin_js.length > 0 ) {
                $.each(multilisting_types_admin_js, function( index, listing_type ) {

                    // toggling dependencies
                    $('[data-dep]').each(function(){
                        var $stmThis = $(this);

                        var managerName = listing_type + '_manager_setting_';

                        var elementDepended = $stmThis.data('dep');

                        $(document).on('change', 'input[name="butterbean_' + managerName + elementDepended + '"]', function(){
                            stmHideUseless(managerName, elementDepended, $stmThis);
                        });

                        stmHideUseless(managerName, elementDepended, $stmThis);
                    });

                    // resetting phone/listing view counters
                    $(document).on('click', '.reset_field', function(e){
                        e.preventDefault();

                        if($(this).data('type') == 'stm_car_views') {
                            $('input[name="butterbean_'+ listing_type +'_manager_setting_stm_car_views"]').val('');
                        } else if($(this).data('type') == 'stm_phone_reveals') {
                            $('input[name="butterbean_'+ listing_type +'_manager_setting_stm_phone_reveals"]').val('');
                        }
                    });
                });
            }
        }

        function stmHideUseless(managerName, elementDepended, stm_this) {

            var depValue = stm_this.data('value').toString();

            var $elementDepended = stm_this.closest('.butterbean-control');

            var $elementDependsInput = $('input[name="butterbean_' + managerName + elementDepended + '"]');

            var elementDependsValue = '';
            if($elementDependsInput.attr('type') == 'checkbox') {
                elementDependsValue = $elementDependsInput.prop('checked');
            } else {
                elementDependsValue = $elementDependsInput.val();
            }

            if ( typeof elementDependsValue === 'undefined' ) return;

            elementDependsValue = elementDependsValue.toString();

            if(depValue !== elementDependsValue) {
                $elementDepended.slideUp();
            } else {
                $elementDepended.slideDown();
            }
        }

        if($('input[name="butterbean_stm_car_manager_setting_car_mark_as_sold"]').is(':checked')) {
            $('input[name="butterbean_stm_car_manager_setting_stm_car_stock"]').val(1);
            $('input[name="butterbean_stm_car_manager_setting_car_mark_woo_online"]').prop('checked', false);
            $('#butterbean-control-stm_car_stock').hide();
        }

    });
})(jQuery);

jQuery(document).ready(function($) {
	if ($('.media-repeater-item').length === 0) {
		$('.butterbean-add-field.add-media-repeater').click()
	}
	if ($('.media-repeater-item').length === 2) {
		$('.butterbean-add-field.add-media-repeater').hide()
	}
	if ($('.video-repeater-item').length === 0) {
		$('.butterbean-add-field.video-repeater').click()
	}

    let previousValue = $('input[name="butterbean_stm_car_manager_setting_car_price_form_label"]').val();

    $('input[name="butterbean_stm_car_manager_setting_car_price_form"]').on('change', function () {
        const labelInput = $('input[name="butterbean_stm_car_manager_setting_car_price_form_label"]');
        if ($(this).is(':checked')) {
            if (previousValue !== '') {
                labelInput.val(previousValue);
            }
        } else {
            previousValue = labelInput.val();
            labelInput.val('');
        }
    });
});
