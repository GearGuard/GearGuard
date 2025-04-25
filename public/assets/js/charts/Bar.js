import {Debugger} from "../util/Debugger.js";
import {Utilities} from "../util/Utilities.js";

export class BarChart {
    #canvasElement;
    #data;
    #height;
    #width;
    #context;
    #backgroundColor = "#eeeeee";
    #borderColor = "#999999";
    #axisColor = "#999999";
    #yAxisFont = "12pt Verdana, sans-serif";
    #xAxisFont = "12pt Verdana, sans-serif";
    #yAxisLabels;
    #xAxisLabels;
    #barStyles;
    #xAxisLabelStyle = "rgba(255, 255, 255, 0.8)";
    #yAxisLabelStyle = "#999999";

    #CHART_PADDING = 20;

    constructor(canvasElement) {
        if (!canvasElement || !(canvasElement instanceof HTMLCanvasElement)) {
            throw "Either invalid element or an element not of type HTMLCanvasElement were provided";
        }
        this.#width = canvasElement.width;
        this.#height = canvasElement.height;

        this.#context = canvasElement.getContext('2d');
    }

    setHeight(height) {
        if (Number.isNaN(height))
            throw "Height must be a number";

        this.#height = height;
        return this;
    }

    getHeight() {
        return this.#height;
    }

    setWidth(width) {
        if (Number.isNaN(width))
            throw "Width must be a number";

        this.#width = width;
        return this;
    }

    getWidth() {
        return this.#width;
    }

    setData(data) {
        if (!data || !Array.isArray(data) || Number.isNaN(data[0])) {
            throw "Data must be an array consisting of numbers";
        }

        this.#data = data;
        return this;
    }

    getData() {
        return this.#data;
    }

    setBackgroundColor(color) {
        this.#backgroundColor = color;
        return this;
    }

    getBackgroundColor() {
        return this.#backgroundColor;
    }

    setBorderColor(color) {
        this.#borderColor = color;
        return this;
    }

    getBorderColor() {
        return this.#borderColor;
    }

    setYAxisFontStyle(axisFont) {
        this.#yAxisFont = axisFont;
        return this;
    }

    getYAxisFontStyle() {
        return this.#yAxisFont;
    }

    setXAxisFontStyle(axisFont) {
        this.#xAxisFont = axisFont;
        return this;
    }

    getXAxisFontStyle() {
        return this.#xAxisFont;
    }

    setAxisColor(axisColor) {
        this.#axisColor = axisColor;
        return this;
    }

    getAxisColor() {
        return this.#axisColor;
    }

    setXAxisLabelStyle(labelStyle) {
        this.#xAxisLabelStyle = labelStyle;
        return this;
    }

    getXAxisLabelStyle() {
        return this.#xAxisLabelStyle;
    }

    setYAxisLabelStyle(labelStyle) {
        this.#yAxisLabelStyle = labelStyle;
        return this;
    }

    getYAxisLabelStyle() {
        return this.#yAxisLabelStyle;
    }

    setGlobalPadding(padding) {
        if (Number.isNaN(padding))
            throw "Padding must be a number";

        this.#CHART_PADDING = padding;
        return this;
    }

    getGlobalPadding() {
        return this.#CHART_PADDING;
    }

    setXAxisLabels(labels) {
        if (!this.#data) {
            throw "Please set data values first";
        }
        if (!labels || !Array.isArray(labels) || labels.length !== this.#data.length) {
            throw "Labels must be an array of the same length as data";
        }

        this.#xAxisLabels = labels;
        return this;
    }

    getXAxisLabels() {
        return this.#xAxisLabels;
    }

    setYAxisLabels(labels) {
        if (!this.#data) {
            throw "Please set data values first";
        }

        if (!Utilities.isNormalizedKeyValueObject(labels)) {
            throw "Labels must be an object with keys between 0 and 1";
        }

        this.#yAxisLabels = labels;
        return this;
    }

    setBarStyles(styles) {
        if (!styles || !Array.isArray(styles)) {
            throw "Styles must be an array consisting of styles";
        }

        this.#barStyles = styles;
        return this;
    }

    getBarStyles() {
        return this.#barStyles;
    }

    draw() {
        if (!this.#context) {
            Debugger.log("Canvas context is not available");
            return;
        }

        this.#context.fillStyle = this.#backgroundColor;
        this.#context.strokeStyle = this.#borderColor;
        this.#context.fillRect(0, 0, this.#width, this.#height);

        this.#drawBars();
        this.#drawAxes();
    }

    #drawAxes() {
        this.#context.save();
        this.#context.font = this.#yAxisFont;
        this.#context.fillStyle = this.#axisColor;

        this.#context.moveTo(this.#CHART_PADDING, this.#CHART_PADDING);
        this.#context.lineTo(this.#CHART_PADDING, this.#height - this.#CHART_PADDING);
        this.#context.lineTo(this.#width - this.#CHART_PADDING, this.#height - this.#CHART_PADDING);

        this.#context.textAlign = "right";
        this.#context.fillStyle = this.#yAxisLabelStyle;

        Object.entries(this.#yAxisLabels).forEach(([key, value]) => {
            this.#context.moveTo(this.#CHART_PADDING, this.#CHART_PADDING + (1 - key) * (this.#height - 2 * this.#CHART_PADDING));
            this.#context.lineTo(this.#CHART_PADDING *1.3, this.#CHART_PADDING + (1 - key) * (this.#height - 2 * this.#CHART_PADDING));
            this.#context.fillText(value.toString(), this.#CHART_PADDING * 2.3, this.#CHART_PADDING + (1 - key) * (this.#height - 2 * this.#CHART_PADDING) + 6);
        });

        this.#context.stroke();
        this.#context.restore();
    }

    #drawBars() {
        this.#context.save();
        let elementWidth = (this.#width - this.#CHART_PADDING * 2) / this.#data.length;
        let stepSize = (this.#height - 2 * this.#CHART_PADDING) / Math.max(...this.#data);

        this.#context.font = this.#xAxisFont;

        this.#context.textAlign = "center";
        for (let i = 0; i < this.#data.length; i++) {
            this.#context.fillStyle = this.#barStyles[i];
            this.#context.fillRect(this.#CHART_PADDING + i * elementWidth, this.#height - this.#CHART_PADDING - this.#data[i] * stepSize, elementWidth, this.#data[i] * stepSize);
            this.#context.fillStyle = this.#xAxisLabelStyle;
            this.#context.fillText(this.#xAxisLabels[i], this.#CHART_PADDING + elementWidth * (i + 0.5), this.#height - this.#CHART_PADDING * 1.5);
        }
        this.#context.restore();
    }

}