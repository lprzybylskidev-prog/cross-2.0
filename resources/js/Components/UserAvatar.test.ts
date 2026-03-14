import { describe, expect, it } from 'vitest';
import { mount } from '@vue/test-utils';
import UserAvatar from './UserAvatar.vue';

describe('UserAvatar', () => {
    it('renders initials when profile photos are unavailable', () => {
        const wrapper = mount(UserAvatar, {
            props: {
                user: {
                    name: 'Cross Admin',
                    profile_photo_url: null,
                },
                size: 'nav',
            },
            global: {
                mocks: {
                    $page: {
                        props: {
                            jetstream: {
                                managesProfilePhotos: false,
                            },
                        },
                    },
                },
            },
        });

        expect(wrapper.text()).toContain('CA');
        expect(wrapper.find('img').exists()).toBe(false);
    });

    it('renders the profile image when jetstream photo support is enabled', () => {
        const wrapper = mount(UserAvatar, {
            props: {
                user: {
                    name: 'Cross Admin',
                    profile_photo_url: 'https://example.test/avatar.png',
                },
            },
            global: {
                mocks: {
                    $page: {
                        props: {
                            jetstream: {
                                managesProfilePhotos: true,
                            },
                        },
                    },
                },
            },
        });

        expect(wrapper.find('img').attributes('src')).toBe('https://example.test/avatar.png');
        expect(wrapper.text()).toBe('');
    });
});
