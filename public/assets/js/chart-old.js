/**
 * Credits: Radu Mariescu-Istodor YouTube Channel. <br>
 * https://www.youtube.com/watch?v=n8uCt1TSGKE
 */
class Chart {
    constructor(container, samples, options, onClick = null) {
        this.samples = samples;

        this.axesLabels = options.axesLabels;
        this.styles = options.styles;
        this.icon = options.icon;
        this.onClick = onClick;

        this.canvas = document.createElement("canvas");
        this.canvas.width = options.size;
        this.canvas.height = options.size;
        this.canvas.style = "background-color: white";
        container.appendChild(this.canvas);

        this.context = this.canvas.getContext("2d");

        this.margin = options.size * 0.1;
        this.transparency = options.transparency || 1;

        this.dataTransform = {
            offset: [0, 0],
            scale: 1,
        };
        this.dragInfo = {
            start: [0, 0],
            end: [0, 0],
            offset: [0, 0],
            isDragging: false,
        };

        this.hoveredSample = null;
        this.selectedSample = null;

        this.pixelBounds = this.#getPixelBounds();
        this.dataBounds = this.#getDataBounds();
        this.defaultDataBounds = this.#getDataBounds();

        this.#draw();

        this.#addEventListeners();
    }

    #addEventListeners() {
        const {canvas, dataTransform, dragInfo} = this;

        canvas.addEventListener("mousedown", (event) => {
            const dataLocation = this.#getMouseLocation(event, true);
            dragInfo.start = dataLocation;
            dragInfo.isDragging = true;
            dragInfo.end = [0, 0];
            dragInfo.offset = [0, 0];
        });
        canvas.addEventListener("mousemove", (event) => {
            if (dragInfo.isDragging) {
                const dataLocation = this.#getMouseLocation(event, true);
                dragInfo.end = dataLocation;
                dragInfo.offset = math.scale(math.subtractVectors(dragInfo.start, dragInfo.end), dataTransform.scale ** 2);
                const newOffset = math.addVectors(dataTransform.offset, dragInfo.offset);
                this.#updateDataBounds(newOffset, dataTransform.scale);
            }

            const pixelLocation = this.#getMouseLocation(event);
            const pixelPoints = this.samples.map(s => math.remapPoint(this.dataBounds, this.pixelBounds, s.point));

            const index = math.getNearestIndex(pixelLocation, pixelPoints);
            const nearest = this.samples[index];
            const distance = math.distance(pixelPoints[index], pixelLocation);

            if (distance < this.margin / 2) {
                this.hoveredSample = nearest;
            } else {
                this.hoveredSample = null;
            }

            this.#draw();
        });

        canvas.addEventListener("mouseup", (event) => {
            dataTransform.offset = math.addVectors(dataTransform.offset, dragInfo.offset);
            dragInfo.isDragging = false;
        });

        canvas.addEventListener("wheel", (event) => {
            event.preventDefault();
            const dir = Math.sign(event.deltaY);
            const step = 0.02;
            dataTransform.scale += dir * step;
            dataTransform.scale = Math.max(step, Math.min(2, dataTransform.scale));

            this.#updateDataBounds(
                dataTransform.offset,
                dataTransform.scale
            )

            this.#draw();
        });

        canvas.addEventListener("click", (event) => {
            if (!math.equals(dragInfo.offset, [0, 0])) {
                return;
            }
            if (this.hoveredSample) {
                if (this.selectedSample == this.hoveredSample) {
                    this.selectedSample = null;
                } else {
                    this.selectedSample = this.hoveredSample;
                }
            } else {
                this.selectedSample = null;
            }

            if (this.onClick) {
                this.onClick(this.selectedSample);
            }
            this.#draw();
        });
    }

    #updateDataBounds(offset, scale) {
        const {dataBounds, defaultDataBounds:def} = this;

        dataBounds.left = def.left + offset[0];
        dataBounds.right = def.right + offset[0];
        dataBounds.top = def.top + offset[1];
        dataBounds.bottom = def.bottom + offset[1];

        const center = [
            (dataBounds.left + dataBounds.right) / 2,
            (dataBounds.top + dataBounds.bottom) / 2,
        ];

        dataBounds.left = math.lerp(center[0], dataBounds.left, scale**2);
        dataBounds.right = math.lerp(center[0], dataBounds.right, scale**2);
        dataBounds.top = math.lerp(center[1], dataBounds.top, scale**2);
        dataBounds.bottom = math.lerp(center[1], dataBounds.bottom, scale**2);
    }

    #getMouseLocation(event, isDataSpace = false) {
        const rect = this.canvas.getBoundingClientRect();
        const pixelLocation = [
            event.clientX - rect.left,
            event.clientY - rect.top,
        ];

        if (isDataSpace) {
            const dataLocation = math.remapPoint(
                this.pixelBounds, this.defaultDataBounds, pixelLocation
            );
            return dataLocation;
        }
        return pixelLocation;
    }

    #getPixelBounds() {
        const {canvas, margin} = this;
        const bounds = {
            left: margin,
            right: canvas.width - margin,
            top: margin,
            bottom: canvas.height - margin,
        }

        return bounds;
    }

    #getDataBounds() {
        const {samples} = this;
        const x = samples.map(s => s.point[0]);
        const y = samples.map(s => s.point[1]);
        const minX = Math.min(...x);
        const maxX = Math.max(...x);
        const minY = Math.min(...y);
        const maxY = Math.max(...y);
        const bounds = {
            left: minX,
            right: maxX,
            top: maxY,
            bottom: minY,
        };

        return bounds;
    }

    #draw() {
        const {context, canvas} = this;
        context.clearRect(0, 0, canvas.width, canvas.height);

        context.globalAlpha = this.transparency;
        this.#drawSamples(this.samples);
        context.globalAlpha = 1;

        if (this.hoveredSample) {
            this.#emphasizeSample(this.hoveredSample);
        }

        if (this.selectedSample) {
            this.#emphasizeSample(this.selectedSample, "yellow");
        }

        this.#drawAxes();
    }

    selectSample(sample) {
        this.selectedSample = sample;
        this.#draw();
    }

    #emphasizeSample(sample, color = "white") {
        const pointLocation = math.remapPoint(
            this.dataBounds, this.pixelBounds, sample.point
        );
        const gradient = this.context.createRadialGradient(...pointLocation, 0, ...pointLocation, this.margin);
        gradient.addColorStop(0, color);
        gradient.addColorStop(1, "rgba(255, 255, 255, 0)");
        graphics.drawPoint(this.context, pointLocation, gradient, this.margin * 2);

        this.#drawSamples([sample]);
    }

    #drawAxes() {
        const {context, canvas, axesLabels, margin} = this;
        const {left, right, top, bottom} = this.pixelBounds;

        context.clearRect(0, 0, this.canvas.width, margin);
        context.clearRect(0, 0, margin, this.canvas.height);
        context.clearRect(this.canvas.width - margin, 0, margin, this.canvas.height);
        context.clearRect(0, this.canvas.height - margin, this.canvas.width, margin);

        graphics.drawText(context, {
            text: axesLabels[0],
            location: [canvas.width/2, bottom + margin/2],
            size: margin * 0.6,
        });

        context.save();
        context.translate(left - margin/2, canvas.height/2);
        context.rotate(- Math.PI / 2);
        graphics.drawText(context, {
            text: axesLabels[1],
            location: [0, 0],
            size: margin * 0.6,
        });
        context.restore();

        context.beginPath();
        context.moveTo(left, top);
        context.lineTo(left, bottom);
        context.lineTo(right, bottom);
        context.setLineDash([5, 4]);
        context.lineWidth = 2;
        context.strokeStyle = "lightgray";
        context.stroke();
        context.setLineDash([]);

        const dataMinimum = math.remapPoint(
            this.pixelBounds, this.dataBounds, [left, bottom]
        );
        graphics.drawText(context, {
            text: math.formatNumber(dataMinimum[0], 2),
            location: [left, bottom],
            size: margin * 0.3,
            align: "left",
            vAlign: "top",
        });
        context.save();

        context.translate(left, bottom);
        context.rotate(- Math.PI / 2);
        graphics.drawText(context, {
            text: math.formatNumber(dataMinimum[1], 2),
            location: [0, 0],
            size: margin * 0.3,
            align: "left",
            vAlign: "bottom",
        });
        context.restore();

        const dataMaximum = math.remapPoint(
            this.pixelBounds, this.dataBounds, [right, top]
        );
        graphics.drawText(context, {
            text: math.formatNumber(dataMaximum[0], 2),
            location: [right, bottom],
            size: margin * 0.3,
            align: "right",
            vAlign: "top",
        });
        context.save();

        context.translate(left, top);
        context.rotate(- Math.PI / 2);
        graphics.drawText(context, {
            text: math.formatNumber(dataMaximum[1], 2),
            location: [0, 0],
            size: margin * 0.3,
            align: "right",
            vAlign: "bottom",
        });
        context.restore();
    }

    #drawSamples(samples) {
        const {context, dataBounds, pixelBounds} = this;

        for (const sample of samples) {
            const {point, label} = sample;
            const pixelLoc = math.remapPoint(
                dataBounds, pixelBounds, point
            );

            switch(this.icon) {
                case "image":
                    graphics.drawImage(context, this.styles[label].image, pixelLoc);
                    break;
                case "text":
                    graphics.drawText(context, {
                        text: this.styles[label].text,
                        location: pixelLoc,
                        size: this.styles[label].size,
                    });
                    break;
                default:
                    graphics.drawPoint(context, pixelLoc, this.styles[label].color);
                    break;
            }
        }
    }
}