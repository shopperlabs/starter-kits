# Shopper Starter Kits

A community-driven registry of starter kits for [Laravel Shopper](https://github.com/shopperlabs/shopper).

Starter kits are scaffold templates installed once — the code belongs to you after installation.

## Installation

Install a kit using the Shopper CLI:

```bash
php artisan shopper:kit:install <package>
```

## Available Starter Kits

### Official

| Name | Package | Description | Tags |
|------|---------|-------------|------|
| [Livewire Storefront](https://github.com/shopperlabs/livewire-starter-kit) | `shopperlabs/livewire-starter-kit` | A full Livewire + Alpine storefront with checkout, accounts, and product pages. | livewire, storefront |

## Submit Your Kit

Want to add your starter kit to this registry? See the [contributing guide](CONTRIBUTING.md).

## What is a Starter Kit?

A starter kit is a **scaffold**, not a theme. It is installed once into your Laravel project and gives you a starting point for building your storefront. After installation, you own the code — modify, delete, or reorganize anything.

Each starter kit is a Composer package or GitHub repository containing a `shopper-kit.yaml` manifest that declares which files to copy, which dependencies to install, and which commands to run after installation.

Learn more in the [Shopper documentation](https://docs.laravelshopper.dev).
