import { cpSync, existsSync } from 'node:fs'
import { resolve } from 'node:path'

const frontendRoot = resolve(process.cwd())
const projectRoot = resolve(frontendRoot, '..')
const apiPublicRoot = resolve(projectRoot, 'api', 'public')

const sourceAssets = resolve(apiPublicRoot, 'assets')
const sourceFavicon = resolve(apiPublicRoot, 'favicon.svg')

const targetAssets = resolve(projectRoot, 'assets')
const targetFavicon = resolve(projectRoot, 'favicon.svg')

if (existsSync(sourceAssets)) {
  cpSync(sourceAssets, targetAssets, { recursive: true, force: true })
}

if (existsSync(sourceFavicon)) {
  cpSync(sourceFavicon, targetFavicon, { force: true })
}
