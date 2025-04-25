/**
 * Credits: Radu Mariescu-Istodor YouTube Channel. <br>
 * https://www.youtube.com/watch?v=n8uCt1TSGKE
 */
const math={};

math.equals = (p1, p2) => {
    return p1[0] === p2[0] && p1[1] === p2[1];
}
math.lerp = (start, end, step) => {
    return start + (end - start) * step;
}

math.invLerp = (start, end, value) => {
    return (value - start) / (end - start);
}

math.remap = (oldStart, oldEnd, newStart, newEnd, value) => {
    return math.lerp(newStart, newEnd, math.invLerp(oldStart, oldEnd, value));
}

math.remapPoint = (oldBounds, newBounds, point) => {
    return [
        math.remap(oldBounds.left, oldBounds.right, newBounds.left, newBounds.right, point[0]),
        math.remap(oldBounds.top, oldBounds.bottom, newBounds.top, newBounds.bottom, point[1]),
    ];
}

math.addVectors = (p1, p2) => {
    return [
        p1[0] + p2[0],
        p1[1] + p2[1],
    ];
}

math.subtractVectors = (p1, p2) => {
    return [
        p1[0] - p2[0],
        p1[1] - p2[1],
    ];
}

math.scale = (p, scaler) => {
    return [
        p[0] * scaler,
        p[1] * scaler,
    ];
}

math.distance = (p1, p2) => {
    return Math.sqrt(
        Math.pow(p1[0] - p2[0], 2) +
        Math.pow(p1[1] - p2[1], 2)
    );
}

math.formatNumber = (number, decimals = 0) => {
    return number.toFixed(decimals);
}

math.getNearestIndex = (location, points) => {
    let minimumDistance = Number.MAX_SAFE_INTEGER;
    let nearestIndex = 0;

    for (let i = 0; i < points.length; i++) {
        const point = points[i];
        const distance = math.distance(location, point);
        if (distance < minimumDistance) {
            nearestIndex = i;
            minimumDistance = distance;
        }
    }

    return nearestIndex;
}