@props(['livewire' => null])

<x-filament-panels::layout.base :livewire="$livewire">
    <style>
        :root {
            --green: #1B4332;
            --green-mid: #2D6A4F;
            --green-light: #40916C;
            --gold: #C9963A;
            --gold-light: #E8B84B;
            --cream: #F8F5EE;
            --cream-dark: #EDE9DF;
            --text-dark: #1A2E27;
            --text-mid: #4A5A52;
            --text-light: #7A7A7A;
            --border: #D8E2DC;
        }

        body {
            background: #fff;
        }

        .lgn-root {
            min-height: 100vh;
            display: flex;
            background: #fff;
        }

        .lgn-aside {
            display: none;
            position: relative;
            width: 50%;
            min-height: 100vh;
            padding: 56px 48px;
            box-sizing: border-box;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(160deg, #1B4332 0%, #2D6A4F 48%, #40916C 100%);
        }

        @media (min-width: 900px) {
            .lgn-aside { display: flex; }
        }

        .lgn-aside::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: 0.14;
            background-image:
                radial-gradient(circle at center, #fff 1px, transparent 1.5px),
                radial-gradient(circle at center, #fff 1px, transparent 1.5px);
            background-size: 56px 56px, 56px 56px;
            background-position: 0 0, 28px 28px;
            mask-image: linear-gradient(180deg, rgba(0,0,0,0.9), rgba(0,0,0,0.35));
        }

        .lgn-aside-inner {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 460px;
            margin: 0 auto;
        }

        .lgn-aside-logo {
            width: 96px;
            height: 96px;
            object-fit: contain;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.94);
            padding: 12px;
            margin: 0 auto 30px;
            box-shadow: 0 16px 44px rgba(0, 0, 0, 0.32);
            display: block;
        }

        .lgn-aside-fallback {
            width: 96px;
            height: 96px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.25);
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 44px rgba(0, 0, 0, 0.32);
            backdrop-filter: blur(4px);
        }

        .lgn-aside-fallback svg {
            width: 44px;
            height: 44px;
            color: #fff;
        }

        .lgn-brand {
            font-size: 2.15rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 12px;
            letter-spacing: -0.5px;
        }

        .lgn-tagline {
            font-size: 1.15rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        .lgn-aside hr {
            width: 56px;
            height: 4px;
            border: 0;
            border-radius: 4px;
            background: var(--gold-light);
            margin: 30px auto;
        }

        .lgn-features {
            display: flex;
            gap: 14px;
            justify-content: center;
            align-items: center;
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.9rem;
        }

        .lgn-feature {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .lgn-feature svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: var(--gold-light);
        }

        .lgn-features-sep {
            display: inline-block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.45);
            flex-shrink: 0;
        }

        .lgn-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            background: #fff;
            box-sizing: border-box;
        }

        .lgn-card {
            width: 100%;
            max-width: 440px;
        }

        .lgn-mobile-head {
            text-align: center;
            margin-bottom: 30px;
        }

        @media (min-width: 900px) {
            .lgn-mobile-head { display: none; }
        }

        .lgn-mobile-logo {
            height: 58px;
            object-fit: contain;
            margin: 0 auto 12px;
            display: block;
        }

        .lgn-heading {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0 0 6px;
            letter-spacing: -0.4px;
        }

        .lgn-sub {
            color: var(--text-light);
            font-size: 0.98rem;
            line-height: 1.6;
            margin: 0 0 26px;
        }

        .lgn-sub a {
            color: var(--green-light);
            font-weight: 600;
            text-decoration: none;
        }

        .lgn-sub a:hover {
            color: var(--green);
        }

        .lgn-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.86rem;
            color: #9aa3ad;
        }

        /* Consistent form inputs */
        .fi-login-form .fi-input {
            border: 1px solid var(--border) !important;
            background-color: #fff !important;
            box-shadow: none !important;
            border-radius: 0.5rem;
            padding: 0.65rem 0.85rem;
            color: var(--text-dark) !important;
        }

        /* Neutralize browser autofill background/outline artifacts */
        .fi-input:-webkit-autofill,
        .fi-input:-webkit-autofill:hover,
        .fi-input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: var(--text-dark) !important;
            caret-color: var(--text-dark);
            border-color: var(--border) !important;
            transition: background-color 9999s ease-in-out 0s;
        }

        .fi-login-form .fi-input:focus {
            border-color: var(--green-mid) !important;
            box-shadow: 0 0 0 2px rgba(45, 106, 79, 0.15) !important;
            outline: none;
        }

        /* Standardize checkboxes */
        .fi-login-form .fi-fo-field-label:has(.fi-checkbox-input) {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .fi-login-form .fi-fo-field-label .fi-checkbox-input {
            flex-shrink: 0;
        }

        .fi-w-undefined {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Keep the branded login page light even if the panel is forced to dark mode */
        .dark .fi-login-form .fi-input {
            background-color: #fff !important;
            border-color: var(--border) !important;
            color: var(--text-dark) !important;
        }

        .dark .fi-login-form .fi-fo-field-label {
            color: var(--text-dark) !important;
        }

        .dark .lgn-main,
        .dark .lgn-root {
            background: #fff;
        }
    </style>
    {{ $slot }}
</x-filament-panels::layout.base>
