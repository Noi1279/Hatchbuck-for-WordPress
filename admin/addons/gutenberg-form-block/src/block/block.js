/**
 * BLOCK: guten-load-hb_form
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { SelectControl } = wp.components;
const { Component } = wp.element;

class mySelecthb_forms extends Component {
	  // Method for setting the initial state.
  static getInitialState( selectedhb_form ) {
    return {
      hb_forms: hatchbuck_forms,
      selectedhb_form: selectedhb_form,
      hb_form: {}, 
    };
  }
  
  // Constructing our component. With super() we are setting everything to 'this'.
  // Now we can access the attributes with this.props.attributes
  constructor() {
    super( ...arguments );
    this.state = this.constructor.getInitialState( this.props.attributes.selectedhb_form );
	
	// Bind so we can use 'this' inside the method.
    this.getOptions = this.getOptions.bind(this);
    // Load posts.
    this.getOptions();
	
    // Bind it.
    this.onChangeSelecthb_form = this.onChangeSelecthb_form.bind(this);
  }
  
  /**
  * Loading Posts
  */
  getOptions() {
    return ( hb_forms ) => {
      if( hb_forms && 0 !== this.state.selectedhb_form ) {
        // If we have a selected Post, find that post and add it.
        const hb_form = hb_forms.find( ( item ) => { return item.id == this.state.selectedhb_form } );
        this.setState( { hb_form, hb_forms } );
      } else {
        this.setState({ hb_form });
      }
    };
  } 
  
  onChangeSelecthb_form( value ) {
    // Find the hb_form
    const hb_form = this.state.hb_forms.find( ( item ) => { return item.id == parseInt( value ) } );
    // Set the state
    this.setState( { selectedhb_form: parseInt( value ), hb_form } );
    // Set the attributes
    this.props.setAttributes( {
      selectedhb_form: parseInt( value ),
      title: hb_form.title,
      content: hb_form.content,
      short_code: hb_form.short_code,
    });
  }  
  
	render() {
	// Options to hold all loaded hatchbuck forms. For now, just the default.
    let options = [ { value: 0, label: __( 'Select a hatchbuck form' ) } ];
	let output  = __( 'Loading hatchbuck forms' );
	//this.props.className += ' loading';
	
	if( this.state.hb_forms.length > 0 ) {
      const loading = __( 'We have %d hatchbuck forms. Choose one.' );
      output = loading.replace( '%d', this.state.hb_forms.length );
      this.state.hb_forms.forEach((hb_form) => {
        options.push({value:hb_form.id, label:hb_form.title});
      });
     } else {
       output = __( 'No hatchbuck forms found. Please create some first.' );
     }
	 
	 // Checking if we have anything in the object
    if( this.state.hb_form.hasOwnProperty('title') ) {
      output = <div>
        <p dangerouslySetInnerHTML={ { __html: this.state.hb_form.short_code } }></p>
        </div>;
    } else {
      //this.props.className += ' no-hb_form';
	  output = <div> </div>;
    }
	 
    return [
    // If we are focused on this block, create the inspector controls.
      !! this.props.isSelected && (
        <SelectControl 
        // Selected value.
		onChange={this.onChangeSelecthb_form}
        value={ this.props.attributes.selectedhb_form } 
        label={ __( 'Select a hatchbuck form' ) } 
        options={ options } />
      ), 
		<div>{output}</div>
     ]
	}
}	

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @short_code https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'cgb/block-guten-load-post', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'hatchbuck forms' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'load' ),
		__( 'Load hatchbuck form' ),
		__( 'hatchbuck forms' ),
	],
	
	  attributes: {
		content: {
		  type: 'array',
		  source: 'children',
		  selector: 'p',
		},
		title: {
		  type: 'string',
		  selector: 'h2'
		},
		short_code: {
		  type: 'string',
		  selector: 'p'
		},
		selectedhb_form: {
		  type: 'number',
		  default: 0,
		},
	  },

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @short_code https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	edit: mySelecthb_forms,

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into hb_form_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @short_code https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	  save: function( props ) {
		return (
			<p> Sample </p>
		//<p dangerouslySetInnerHTML={ { __html: props.attributes.short_code } }></p>
		);
	  },
} );
