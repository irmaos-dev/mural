import { Skeleton } from '~6shared/ui/skeleton'
import { Stack } from '~6shared/ui/stack'
import { ArticlesFeedSkeleton } from '~3widgets/articles-feed'

export function HomePageSkeleton() {
  return (
    <div className="home-page">
      <div className="banner">
        <div className="container">
          <Stack
            direction="column"
            alignItems="center"
          >
            <Skeleton
              variant="text"
              width={200}
              height={50}
            />
            <Skeleton
              variant="text"
              width={300}
              height={36}
            />
          </Stack>
        </div>
      </div>

      <div className="container page">
        <div className="row">
          <div className="col-md-9">
            <ul className="nav nav-pills outline-active">
              <li className="nav-item">
                <Skeleton
                  width={100}
                  height={16}
                />
              </li>
            </ul>

            <ArticlesFeedSkeleton />
          </div>

          <div className="col-md-3">
            <div className="sidebar">
              <Skeleton
                width="100%"
                height={180}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
