import {Browser} from "./util/Browser.js";
import {Debugger} from "./util/Debugger.js";
import {BarChart} from "./charts/Bar.js";

export function init () {
    if (!Browser.isCanvasSupported()) {
        Debugger.log("Canvas not supported");
        return;
    } else {
        Debugger.log("Canvas supported");
    }
}

export function initBarChart(canvasElement) {
    if (!canvasElement || !canvasElement instanceof HTMLCanvasElement) {
        Debugger.log("Either invalid element or an element not of type HTMLCanvasElement were provided");
        return null;
    }
    return new BarChart(canvasElement);
}
