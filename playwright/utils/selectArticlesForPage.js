async function selectArticlesForPage(page, number = 3) {
  let selectedArticles = [];
  // Espera os artigos serem carregadas e visíveis
  await page.waitForSelector(".article-preview", { state: "visible" });

  const homeArticles = await page.locator(".article-preview").all();
  if (homeArticles.length == 0) {
    throw new Error("Nenhuma artigo encontrado na página");
  }

  if (number == 0 || homeArticles.length <= number) {
    selectedArticles = homeArticles;
  } else {
    selectedArticles = homeArticles.sort(() => 0.5 - Math.random()).slice(0, number);
  }

  return selectedArticles;
}

module.exports = { selectArticlesForPage };