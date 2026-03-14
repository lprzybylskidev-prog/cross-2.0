import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { translate } from '../lib/translate';

export const useTranslations = () => {
    const page = usePage();

    const translations = computed(() => page.props.translations ?? {});

    const t = (key, replacements = {}) => translate(translations.value, key, replacements);

    return {
        t,
        translations,
    };
};
