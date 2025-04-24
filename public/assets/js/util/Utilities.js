export const Utilities = {
    isNormalizedKeyValueObject(obj) {
        if (
            obj === null ||
            typeof obj !== 'object' ||
            Array.isArray(obj)
        ) {
            return false;
        }

        return Object.entries(obj).every(([key, value]) => {
            const numericKey = parseFloat(key);
            const isKeyValid =
                !isNaN(numericKey) &&
                numericKey >= 0 &&
                numericKey <= 1;

            const isValueStringable =
                value !== null && value !== undefined &&
                typeof value.toString === 'function';

            return isKeyValid && isValueStringable;
        });
    }
}