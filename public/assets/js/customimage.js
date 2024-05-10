import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import Widget from '@ckeditor/ckeditor5-widget/src/widget';
import { toWidget } from '@ckeditor/ckeditor5-widget/src/utils';

export default class CustomImagePlugin extends Plugin {
    init() {
        const editor = this.editor;

        editor.model.schema.extend( '$block', { allowAttributes: 'class' } );

        editor.conversion.for( 'upcast' ).elementToElement( {
            view: 'figure',
            model: ( viewFigure, { writer: modelWriter } ) => {
                const attributes = viewFigure.getAttributes();
                return modelWriter.createElement( 'figure', attributes );
            }
        } );

        editor.conversion.for( 'downcast' ).elementToElement( {
            model: 'figure',
            view: ( modelFigure, { writer: viewWriter } ) => {
                const figureElement = viewWriter.createContainerElement( 'figure', { class: 'gambar' } );
                const imageElement = viewWriter.createEmptyElement( 'img', { src: modelFigure.getAttribute( 'src' ) } );
                viewWriter.insert( viewWriter.createPositionAt( figureElement, 0 ), imageElement );

                return toWidget( figureElement, viewWriter, { label: 'Image widget' } );
            }
        } );
    }
}
