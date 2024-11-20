elementorCommon.elements.$window.on("elementor/nested-element-type-loaded", (function () {
    class AlpusNestedSlider extends elementor.modules.elements.types.NestedElementBase {
        getType() {
            return "alpus-nested-slider"
        }
    }
    elementor.elementsManager.registerElementType(new AlpusNestedSlider);

    class AlpusNestedImageAccordion extends elementor.modules.elements.types.NestedElementBase {
        getType() {
            return "alpus-nested-image-accordion"
        }
    }
    elementor.elementsManager.registerElementType(new AlpusNestedImageAccordion);

    class AlpusNestedInteractiveBanners extends elementor.modules.elements.types.NestedElementBase {
        getType() {
            return "alpus-nested-interactive-banners"
        }
    }
    elementor.elementsManager.registerElementType(new AlpusNestedInteractiveBanners);

    class AlpusNestedHscroller extends elementor.modules.elements.types.NestedElementBase {
        getType() {
            return "alpus-nested-hscroller"
        }
    }
    elementor.elementsManager.registerElementType(new AlpusNestedHscroller);    
}));