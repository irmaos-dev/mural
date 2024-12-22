// @ts-check
const { test, expect } = require('@playwright/test');

test('has title', async ({ page }) => {
 await page.goto("/", { timeout: 60000, waitUntil: 'load' });

  // Expect a title "to contain" a substring.
  await expect(page).toHaveTitle(/Conduit/);
});
