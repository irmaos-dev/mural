import { ReactNode } from 'react'
import { useLoaderData } from 'react-router-dom'
import { routerTypes } from '~6shared/lib/react-router'
import { CreateArticleForm, UpdateArticleForm } from '~4features/article'

export function CreateEditorPage() {
  return (
    <EditorPageWrapper>
      <CreateArticleForm />
    </EditorPageWrapper>
  )
}

export function UpdateEditorPage() {
  const { params } = useLoaderData() as routerTypes.EditorPageData
  const { slug } = params

  return (
    <EditorPageWrapper>
      <UpdateArticleForm slug={slug} />
    </EditorPageWrapper>
  )
}

function EditorPageWrapper(props: { children: ReactNode }) {
  const { children } = props
  return (
    <div className="editor-page">
      <div className="container page">
        <div className="row">
          <div className="col-md-10 offset-md-1 col-xs-12">{children}</div>
        </div>
      </div>
    </div>
  )
}
