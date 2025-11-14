/**
 * Credits: Radu Mariescu-Istodor YouTube Channel. <br>
 * https://www.youtube.com/watch?v=n8uCt1TSGKE
 */
const graphics = {};

graphics.drawPoint = (context, location, color = 'black', radius = 4) => {
    context.beginPath();
    context.fillStyle = color;
    context.arc(...location, radius, 0, 2 * Math.PI);
    context.fill();
}

graphics.drawText = (context,
    {
        text, location, align = "center", vAlign = 'middle', size = 10, color = "black"
    }) => {

    context.textAlign = align;
    context.textBaseline = vAlign;
    context.font = "bold " + size + "px Courier";
    context.fillStyle = color;
    context.fillText(text, ...location);
}

graphics.generateImages = (styles, size = 20) => {
    for (let label in styles) {
        const style = styles[label];
        const canvas = document.createElement("canvas");
        canvas.width = size + 10;
        canvas.height = size + 10;
        const context = canvas.getContext("2d");

        context.beginPath();
        context.textAlign = "center";
        context.textBaseline = "middle";
        context.font = size + "px Courier";

        const colorHueMap = {
            red: 0,
            yellow: 60,
            green: 120,
            cyan: 180,
            blue: 240,
            magenta: 300,
        };
        const hue =- 45 + colorHueMap[style.color];
        if (!isNaN(hue)) {
            context.filter = `
                brightness(2)
                contrast(0.3)
                sepia(1)
                brightness(0.7)
                hue-rotate(${hue}deg)
                saturate(3)
                contrast(3)
            `;
        } else {
            context.filter = "grayscale(1)";
        }

        context.fillText(style.text, canvas.width / 2, canvas.height / 2);

        style["image"] = new Image();
        style["image"].src = canvas.toDataURL();
    }
}

graphics.drawImage = (context, image, location) => {
    context.beginPath();
    context.drawImage(image, location[0] - image.width / 2, location[1] - image.height / 2, image.width, image.height);
    context.fill();
}