/** reworked 2016.08 https://osworx.net */
(function ($) {
  $.extend($.summernote.lang, {
    'de': {
      font: {
        bold: 'Fett',
		italic: 'Kursiv',
		underline: 'Unterstrichen',
		strikethrough: 'Durchgestrichen',
		subscript: 'Tiefgestellt',
		superscript: 'Hochgestellt',
		clear: 'Schriftart entfernen',
		height: 'Zeilenhöhe',
		name: 'Schriftart',
		size: 'Schriftgröße'
      },
      image: {
        image: 'Bild',
        insert: 'Bild einfügen',
        resizeFull: 'Originalgröße',
        resizeHalf: 'Größe 1/2',
        resizeQuarter: 'Größe 1/4',
        floatLeft: 'Linksbündig',
        floatRight: 'Rechtsbündig',
        floatNone: 'Kein Textfluss',
        dragImageHere: 'Bild mit Maus hierher ziehen',
        selectFromFiles: 'Datei auswählen',
        url: 'Bild-URL',
        remove: 'Bild entfernen'
      },
      link: {
        link: 'Link',
        insert: 'Link einfügen',
        unlink: 'Link entfernen',
        edit: 'Bearbeiten',
        textToDisplay: 'Anzeigetext',
        url: 'Link-URL',
        openInNewWindow: 'In neuem Fenster öffnen'
      },
      table: {
        table: 'Tabelle'
      },
      hr: {
        insert: 'Horizontale Linie einfügen'
      },
      style: {
        style: 'Stil',
        normal: 'Normal',
        blockquote: 'Zitat',
        pre: 'Code',
        h1: 'Überschrift 1',
        h2: 'Überschrift 2',
        h3: 'Überschrift 3',
        h4: 'Überschrift 4',
        h5: 'Überschrift 5',
        h6: 'Überschrift 6'
      },
      lists: {
        unordered: 'Aufzählung',
        ordered: 'Nummerierung'
      },
      options: {
        help: 'Hilfe',
        fullscreen: 'Vollbild',
        codeview: 'HTML-Code anzeigen'
      },
      paragraph: {
        paragraph: 'Absatz',
        outdent: 'Einzug vergrößern',
        indent: 'Einzug verkleinern',
        left: 'Links ausrichten',
        center: 'Zentriert ausrichten',
        right: 'Rechts ausrichten',
        justify: 'Blocksatz'
      },
      color: {
        recent: 'Aktuelle Farbe',
        more: 'Mehr Farben',
        background: 'Hintergrundfarbe',
        foreground: 'Schriftfarbe',
        transparent: 'Transparenz',
        setTransparent: 'Transparenz setzen',
        reset: 'Zurücksetzen',
        resetToDefault: 'Auf Standard zurücksetzen'
      },
      shortcut: {
        shortcuts: 'Tastenkürzel',
        close: 'Schließen',
        textFormatting: 'Textformatierung',
        action: 'Aktion',
        paragraphFormatting: 'Absatzformatierung',
        documentStyle: 'Dokumentenstil'
      },
      history: {
        undo: 'Rückgängig',
        redo: 'Wiederholen'
      }
	  // + OSWorX
	  ,
      video: {
      	video: 'Video',
	  	videoLink: 'Videolink',
	  	insert: 'Video  einfügen',
	  	url: 'Video URL',
	  	providers: '(YouTube, Vimeo, Vine, Instagram, DailyMotion oder Youku)'
      },
      help: {
        'insertParagraph': 'Neue Zeile (p einfügen)',
        'undo': 'Rückgängig',
        'redo': 'Wiederholen',
        'tab': 'Tab',
        'untab': 'Untab',
        'bold': 'Fettschrift',
        'italic': 'Schrägschrift',
        'underline': 'Unterstreichen',
        'strikethrough': 'Durchstreichen',
        'removeFormat': 'Format entfernen',
        'justifyLeft': 'Linksbündig',
        'justifyCenter': 'Zentriert',
        'justifyRight': 'Rechtsbündig',
        'justifyFull': 'Blocksatz',
        'insertUnorderedList': 'Unnummerierte Liste',
        'insertOrderedList': 'Nummerierte Liste',
        'outdent': 'Einrücken',
        'indent': 'Nach Links rücken',
        'formatPara': 'Aktuellen Block mit p formatieren',
        'formatH1': 'Aktuellen Block als H1 formatieren',
        'formatH2': 'Aktuellen Block als H2 formatieren',
        'formatH3': 'Aktuellen Block als H3 formatieren',
        'formatH4': 'Aktuellen Block als H4 formatieren',
        'formatH5': 'Aktuellen Block als H5 formatieren',
        'formatH6': 'Aktuellen Block als H6 formatieren',
        'insertHorizontalRule': 'Horizontale Linie einfügen',
        'linkDialog.show': 'Zeige Link Dialog'
      },
      specialChar: {
        specialChar: 'SONDERZEICHEN',
        select: 'Sonderzeichen auswählen'
      }
    }
  });
})(jQuery);