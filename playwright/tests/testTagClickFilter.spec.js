const { test, expect } = require("@playwright/test");

test.describe("Teste de filtragem e navegação por tags populares", () => {
  let selectedButtons = [];

  test.beforeEach(async ({ page }) => {
    await page.goto("/");

    const buttons = await page.locator(".tag-list button").all();

    if (buttons.length <= 3) {
      selectedButtons = buttons;
    } else {
      selectedButtons = buttons.sort(() => 0.5 - Math.random()).slice(0, 3);
    }
  });

  async function verifyTagTabOpened(button, page) {
    const text = await button.textContent();
    const cleanText = text.replace("#", "").trim(); // Retira a # do texto da tag

    await button.click();

    const liButton = page.locator(".nav.nav-pills.outline-active li button").withText(cleanText);

    const count = await liButton.count();
    expect(count).toBeGreaterThan(0);
  }

  async function verifyArticlesHaveTag(button, page) {
    await button.click();
    const articles = await page.locator(".article-preview");
    const tag = await button.textContent();
    const cleanTag = tag.replace("#", "").trim();

    const articlesCount = await articles.count();
    expect(articlesCount).toBeGreaterThan(0);

    for (let i = 0; i < articlesCount; i++) {
      const article = articles.nth(i);
      const articleTags = await article.locator(".tag-list").textContent();
      expect(articleTags).toContain(cleanTag);
    }
  }

  test("Verifica se a aba correta é aberta ao clicar na tag", async ({ page }) => {
    for (const button of selectedButtons) {
      await verifyTagTabOpened(button, page);
    }
  });

  test("Verifica se todos os artigos contêm a tag clicada", async ({ page }) => {
    for (const button of selectedButtons) {
      await verifyArticlesHaveTag(button, page);
    }
  });
});
