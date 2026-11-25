( function ( wp ) {
	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var be = wp.blockEditor;
	var c = wp.components;
	var __ = wp.i18n.__;

	function picker( props, key, label ) {
		var url = props.attributes[ key + 'Url' ];
		return el( 'div', { style: { marginBottom: 16 } },
			el( 'p', { style: { fontWeight: 600, margin: '0 0 8px' } }, label ),
			url ? el( 'img', { src: url, alt: '', style: { width: '100%', borderRadius: 8, marginBottom: 8 } } ) : null,
			el( be.MediaUploadCheck, null,
				el( be.MediaUpload, {
					allowedTypes: [ 'image' ],
					value: props.attributes[ key + 'Id' ],
					onSelect: function ( m ) {
						var o = {};
						o[ key + 'Id' ] = m.id;
						o[ key + 'Url' ] = ( m.sizes && m.sizes.large ? m.sizes.large.url : m.url );
						o[ key + 'Alt' ] = props.attributes[ key + 'Alt' ] || m.alt || '';
						props.setAttributes( o );
					},
					render: function ( r ) {
						return el( c.Button, { variant: 'secondary', onClick: r.open }, url ? __( 'Replace image', 'dermatex' ) : __( 'Choose image', 'dermatex' ) );
					}
				} )
			),
			url ? el( c.Button, { variant: 'link', isDestructive: true, style: { marginLeft: 8 }, onClick: function () {
				var o = {}; o[ key + 'Id' ] = undefined; o[ key + 'Url' ] = ''; props.setAttributes( o );
			} }, __( 'Remove', 'dermatex' ) ) : null,
			el( c.TextControl, {
				label: __( 'Alt text', 'dermatex' ),
				value: props.attributes[ key + 'Alt' ],
				onChange: function ( v ) { var o = {}; o[ key + 'Alt' ] = v; props.setAttributes( o ); }
			} )
		);
	}

	wp.blocks.registerBlockType( 'dermatex/compare', {
		edit: function ( props ) {
			var a = props.attributes;
			var blockProps = be.useBlockProps( { className: 'dx-compare', style: { '--dx-pos': a.start + '%' } } );
			var has = a.beforeUrl && a.afterUrl;
			return el( Fragment, null,
				el( be.InspectorControls, null,
					el( c.PanelBody, { title: __( 'Photos', 'dermatex' ), initialOpen: true },
						picker( props, 'before', __( 'Before photo', 'dermatex' ) ),
						picker( props, 'after', __( 'After photo', 'dermatex' ) )
					),
					el( c.PanelBody, { title: __( 'Labels and caption', 'dermatex' ), initialOpen: false },
						el( c.TextControl, { label: __( 'Before label', 'dermatex' ), value: a.beforeLabel, onChange: function ( v ) { props.setAttributes( { beforeLabel: v } ); } } ),
						el( c.TextControl, { label: __( 'After label', 'dermatex' ), value: a.afterLabel, onChange: function ( v ) { props.setAttributes( { afterLabel: v } ); } } ),
						el( c.TextControl, { label: __( 'Caption', 'dermatex' ), value: a.caption, onChange: function ( v ) { props.setAttributes( { caption: v } ); } } ),
						el( c.RangeControl, { label: __( 'Starting position (%)', 'dermatex' ), min: 0, max: 100, value: a.start, onChange: function ( v ) { props.setAttributes( { start: v } ); } } )
					)
				),
				el( 'figure', blockProps,
					el( 'div', { className: 'dx-compare__stage' },
						el( 'div', { className: 'dx-compare__pane dx-compare__after' }, has ? el( 'img', { src: a.afterUrl, alt: a.afterAlt } ) : el( 'p', { className: 'dx-compare__ph' }, a.placeholderAfter ), el( 'span', { className: 'dx-compare__label dx-compare__label--after' }, a.afterLabel ) ),
						el( 'div', { className: 'dx-compare__pane dx-compare__before' }, has ? el( 'img', { src: a.beforeUrl, alt: a.beforeAlt } ) : el( 'p', { className: 'dx-compare__ph' }, a.placeholderBefore ), el( 'span', { className: 'dx-compare__label dx-compare__label--before' }, a.beforeLabel ) ),
						el( 'span', { className: 'dx-compare__handle' } )
					),
					a.caption ? el( 'figcaption', { className: 'dx-compare__caption' }, a.caption ) : null
				)
			);
		},
		save: function () { return null; }
	} );
} )( window.wp );
