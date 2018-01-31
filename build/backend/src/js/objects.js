const styleProps = {
    minHeight: '100px',
    paddingTop: '',
    paddingRight: '',
    paddingBottom: '',
    paddingLeft: '',
    marginTop: '',
    marginRight: '',
    marginBottom: '',
    marginLeft: ''
};

const commonProps = {
    id: null,
    uniqueId: '',
    type: '',
    displayName: '',
    className: '',
    htmlId: '',
    dropZone: false,
    styles: {
        desktop: styleProps,
        tablet: styleProps,
        mobile: styleProps
    },
    children: []
};


const Section = Object.assign({}, commonProps);
Section.type = 'section';
Section.displayName = 'Section';
Section.className = 'section';
Section.dropZone = true;


export { Section }

