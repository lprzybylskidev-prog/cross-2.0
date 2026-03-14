export const translate = (translations, key, replacements = {}) => {
    const segments = key.split('.');

    let value = translations;

    for (const segment of segments) {
        value = value?.[segment];
    }

    if (typeof value !== 'string') {
        return key;
    }

    return Object.entries(replacements).reduce(
        (message, [replacementKey, replacementValue]) =>
            message.replaceAll(`:${replacementKey}`, String(replacementValue)),
        value
    );
};
