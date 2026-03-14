export const getUserInitials = (name: string | null | undefined): string => {
    if (!name) {
        return '?';
    }

    const parts = name.trim().split(/\s+/).filter(Boolean).slice(0, 2);

    if (parts.length === 0) {
        return '?';
    }

    return parts.map((part) => part.charAt(0).toUpperCase()).join('');
};
