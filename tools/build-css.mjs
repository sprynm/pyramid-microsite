import { fileURLToPath, pathToFileURL } from 'url';
import path from 'path';
import fs from 'fs/promises';
import * as sass from 'sass';
import postcss from 'postcss';
import autoprefixer from 'autoprefixer';
import * as csso from 'csso';

const projectRoot = fileURLToPath(new URL('..', import.meta.url));
const scssEntry = path.join(projectRoot, 'webroot', 'css', 'scss', 'stylesheet.scss');
export const cssOutput = path.join(projectRoot, 'webroot', 'css', 'stylesheet.css');

export async function buildCSS(options = {}) {
  const mode = options.mode === 'prod' || options.mode === 'production' ? 'prod' : 'dev';
  const log = options.log ?? console.log;

  try {
    log(`[css] Compiling (${mode})…`);
    const sassResult = await sass.compileAsync(scssEntry, {
      style: mode === 'prod' ? 'expanded' : 'expanded',
      loadPaths: [path.dirname(scssEntry)],
      sourceMap: false
    });

    let css = sassResult.css;
    const postcssResult = await postcss([
      autoprefixer({ overrideBrowserslist: ['last 2 versions'] })
    ]).process(css, { from: undefined });

    css = postcssResult.css;

    if (mode === 'prod') {
      css = csso.minify(css).css;
    }

    await fs.mkdir(path.dirname(cssOutput), { recursive: true });
    await fs.writeFile(cssOutput, css, 'utf8');
    log(`[css] Wrote ${path.relative(projectRoot, cssOutput)}`);
  } catch (error) {
    console.error('[css] Build failed:', error);
    if (!options.silent) {
      throw error;
    }
  }
}

async function runFromCLI() {
  const args = process.argv.slice(2);
  const modeArg = args.find((arg) => arg.startsWith('--mode='));
  const mode =
    args.includes('--prod') || args.includes('--production')
      ? 'prod'
      : modeArg
      ? modeArg.split('=')[1]
      : 'dev';

  await buildCSS({ mode });
}

const invokedDirectly =
  typeof process !== 'undefined' &&
  process.argv[1] &&
  pathToFileURL(process.argv[1]).href === import.meta.url;

if (invokedDirectly) {
  runFromCLI().catch((error) => {
    console.error(error);
    process.exitCode = 1;
  });
}
