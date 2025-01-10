// @ts-check
const { defineConfig, devices } = require("@playwright/test");
const { trace } = require("console");
const { parse } = require("path");

/**
 * Read environment variables from file.
 * https://github.com/motdotla/dotenv
 */
require("dotenv").config();

/**
 * @see https://playwright.dev/docs/test-configuration
 */

module.exports = defineConfig({
  globalSetup:
    !process.env.SERVER_AUTO_MANAGEMENT || process.env.SERVER_AUTO_MANAGEMENT === "true"
      ? "./utils/global-setup.js"
      : undefined,

  globalTeardown:
    !process.env.SERVER_AUTO_MANAGEMENT || process.env.SERVER_AUTO_MANAGEMENT === "true"
      ? "./utils/global-teardown.js"
      : undefined,

  testDir: "./tests",

  fullyParallel: true,

  forbidOnly: process.env.CI && process.env.CI == "true" ? true : false,

  retries: process.env.RETRIES ? parseInt(process.env.RETRIES) : 0,

  workers: process.env.WORKERS ? parseInt(process.env.WORKERS) : 1,

  timeout: process.env.TIMEOUT ? parseInt(process.env.TIMEOUT) : 120000,

  reporter: "html",

  use: {
    baseURL: process.env.BASE_URL
      ? process.env.BASE_URL + ":" + process.env.PORT
      : "http://127.0.0.1:3000",

    trace: "on-first-retry",
  },

  testIgnore: "tests-examples/*",

  /* Configure projects for major browsers */
  projects: [
    {
      name: "chromium",
      use: { ...devices["Desktop Chrome"] },
    },

    {
      name: "firefox",
      use: { ...devices["Desktop Firefox"] },
    },

    {
      name: "webkit",
      use: { ...devices["Desktop Safari"] },
    },

    /* Test against mobile viewports. */
    // {
    //   name: 'Mobile Chrome',
    //   use: { ...devices['Pixel 5'] },
    // },
    // {
    //   name: 'Mobile Safari',
    //   use: { ...devices['iPhone 12'] },
    // },

    /* Test against branded browsers. */
    // {
    //   name: 'Microsoft Edge',
    //   use: { ...devices['Desktop Edge'], channel: 'msedge' },
    // },
    // {
    //   name: 'Google Chrome',
    //   use: { ...devices['Desktop Chrome'], channel: 'chrome' },
    // },
  ],

  /* Run your local dev server before starting the tests */
  // webServer: {
  //   command: 'npm run start',
  //   url: 'http://127.0.0.1:3000',
  //   reuseExistingServer: !process.env.CI,
  // },
});
