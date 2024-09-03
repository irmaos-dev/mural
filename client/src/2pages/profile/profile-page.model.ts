import { LoaderFunctionArgs, redirect } from 'react-router-dom'
import { queryClient } from '~6shared/lib/react-query'
import { pathKeys, routerContracts } from '~6shared/lib/react-router'
import { SessionQueries, useSessionStore } from '~6shared/session'
import { tabsModel } from '~6shared/ui/tabs'
import { ArticleQueries } from '~5entities/article'
import { ProfileQueries } from '~5entities/profile'
import { ProfileArticleFilter, filterArticleModel } from '~4features/article'

export class ProfileLoader {
  static async indexPage() {
    return redirect(pathKeys.page404())
  }

  static async userPage(args: LoaderFunctionArgs) {
    return ProfileLoader.profilePage(args, boundSetAuthorFeed)
  }

  static async favoritePage(args: LoaderFunctionArgs) {
    return ProfileLoader.profilePage(args, boundSetFavoriteFeed)
  }

  private static async profilePage(
    args: LoaderFunctionArgs,
    setTabFunction: (username: string) => void,
  ) {
    const profileData = ProfileLoader.getProfileData(args)
    const { username } = profileData.params

    const filter = profileModel.useProfileArticleFilterStore.getState()
    const infinityQuery = ArticleQueries.articlesInfiniteQuery(filter)

    const promises = [
      queryClient.prefetchQuery(ProfileQueries.profileQuery(username)),
      queryClient.prefetchInfiniteQuery(infinityQuery),
    ]

    setTabFunction(username)

    if (useSessionStore.getState().session) {
      const currentUserQuery = SessionQueries.currentSessionQuery()
      promises.push(queryClient.prefetchQuery(currentUserQuery))
    }

    Promise.all(promises)

    return profileData
  }

  private static getProfileData(args: LoaderFunctionArgs) {
    return routerContracts.ProfilePageArgsSchema.parse(args)
  }
}

class ProfileModel implements ProfileArticleFilter {
  readonly useProfileArticleFilterStore

  readonly useProfileTabsStore

  constructor() {
    this.useProfileArticleFilterStore =
      filterArticleModel.createArticleFilterStore({
        devtoolsOptions: { name: 'Profile Article Filter Store' },
      })

    this.useProfileTabsStore = tabsModel.createTabsStore({
      initialState: { tab: 'author-feed' },
      devtoolsOptions: { name: 'Profile Tabs Store' },
    })
  }

  onTabChange = (username: string) => (tab: string) => {
    if (tab === 'author-feed') this.setAuthorFeed(username)
    if (tab === 'favorite-feed') this.setFavoriteFeed(username)
  }

  useTab() {
    return this.useProfileTabsStore.use.tab()
  }

  setAuthorFeed(username: string) {
    this.useProfileArticleFilterStore.getState().reset()
    this.useProfileArticleFilterStore.getState().setAuthor(username)
    this.useProfileTabsStore.getState().setTab('author-feed')
  }

  setFavoriteFeed(username: string) {
    this.useProfileArticleFilterStore.getState().reset()
    this.useProfileArticleFilterStore.getState().setFavorited(username)
    this.useProfileTabsStore.getState().setTab('favorite-feed')
  }
}

export const profileModel = new ProfileModel()

const boundSetAuthorFeed = profileModel.setAuthorFeed.bind(profileModel)
const boundSetFavoriteFeed = profileModel.setFavoriteFeed.bind(profileModel)
