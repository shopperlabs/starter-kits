# Contributing a Starter Kit

Want to share your Shopper starter kit with the community? Add it to the registry by opening a pull request.

## Requirements

Before submitting, make sure your starter kit meets these criteria:

1. **Hosted on GitHub** - Your starter kit must be in a public GitHub repository (Packagist is optional — the installer supports GitHub repos directly)
2. **Valid manifest** - Your repo must contain a `shopper-kit.yaml` at the root
3. **Clear README** - Your repo must have a README with installation instructions
4. **Shopper version constraint** - Your `shopper-kit.yaml` must specify a `shopper` version requirement

## How to submit

1. Fork this repository
2. Add your kit entry to the `kits` array in `registry.json`:

```json
{
    "name": "My Awesome Storefront",
    "slug": "my-awesome-storefront",
    "package": "your-vendor/starter-kit-name",
    "repo": "your-vendor/starter-kit-name",
    "description": "A short description of what your kit provides (max 200 chars).",
    "author": "your-vendor",
    "shopper": "^2.7",
    "tags": ["livewire", "storefront"],
    "official": false,
    "preview": null
}
```

3. Open a pull request

## Field reference

| Field | Description | Rules |
|-------|-------------|-------|
| `name` | Display name | Required, non-empty |
| `slug` | URL-safe unique identifier | Required, lowercase kebab-case |
| `package` | Composer package name or GitHub `owner/repo` | Required, `vendor/name` format |
| `repo` | GitHub repository path | Required, `owner/repo` format |
| `description` | Short description | Required, max 200 characters |
| `author` | Author or organization name | Required |
| `shopper` | Shopper version constraint | Required, semver (e.g. `^2.7`) |
| `tags` | Categorization tags | At least one, lowercase |
| `official` | Whether it's maintained by shopperlabs | Must be `false` for community kits |
| `preview` | URL to a live demo | `null` if no demo available |

## Common tags

Use existing tags when possible:

- `livewire` - Uses Livewire components
- `inertia` - Uses Inertia.js
- `blade` - Uses Blade templates
- `vue` - Uses Vue.js
- `react` - Uses React
- `storefront` - Full storefront implementation
- `headless` - API-only scaffold
- `minimal` - Lightweight starting point

## Validation

Your PR will be automatically validated:

- JSON syntax and schema compliance
- Unique `slug` and `package` values
- GitHub repository exists and contains a `shopper-kit.yaml`

## Guidelines

- Set `official` to `false` - only kits maintained by shopperlabs are official
- Keep your description concise and descriptive
- Choose a unique, descriptive slug
- Use relevant tags to help developers find your kit
