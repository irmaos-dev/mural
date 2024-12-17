import * as React from 'react'
import { zodResolver } from '@hookform/resolvers/zod'
import { useSuspenseQuery } from '@tanstack/react-query'
import { withErrorBoundary } from 'react-error-boundary'
import { useForm } from 'react-hook-form'
import { commentContractsDto, commentTypesDto } from '~6shared/api/comment'
import { compose, withSuspense } from '~6shared/lib/react'
import { hasMessages } from '~6shared/lib/react-hook-form'
import { SessionQueries } from '~6shared/session'
import { ErrorHandler, logError } from '~6shared/ui/error-handler'
import { ErrorList } from '~6shared/ui/error-list'
import { transformCreateCommentDtoToComment } from './create-comment.lib'
import { useCreateCommentMutation } from './create-comment.mutation'
import { CreateCommentFormSkeleton } from './create-comment.skeleton'

type CreateCommentFormProps = {
  slug: string
}

const enhance = compose<CreateCommentFormProps>(
  (component) =>
    withErrorBoundary(component, {
      FallbackComponent: ErrorHandler,
      onError: logError,
    }),
  (component) =>
    withSuspense(component, { FallbackComponent: CreateCommentFormSkeleton }),
)

export const CreateCommentForm = enhance((props: CreateCommentFormProps) => {
  const { slug } = props

  const { data: session } = useSuspenseQuery(
    SessionQueries.currentSessionQuery(),
  )

  const {
    register,
    handleSubmit,
    setError,
    setValue,
    reset,
    formState: { errors, isDirty, isValid },
  } = useForm<commentTypesDto.CreateCommentDto>({
    mode: 'onChange',
    resolver: zodResolver(commentContractsDto.CreateCommentDtoSchema),
    defaultValues: { body: '' },
  })

  const { mutate } = useCreateCommentMutation({
    mutationKey: [slug],

    onMutate: () => {
      setValue('body', '')
    },

    onError: (error) => {
      setError('root', { message: error.message })
    },
  })

  const canSubmit = [isDirty, isValid].every(Boolean)

  const onSubmit = (createCommentDto: commentTypesDto.CreateCommentDto) => {
    if (!session)
      throw new Error('Session does not exist. Please log in and try again.')

    const comment = transformCreateCommentDtoToComment({
      createCommentDto,
      session,
    })
    mutate({ slug, comment })
    reset()
  }

  const handleKeyDown = (event: React.KeyboardEvent<HTMLTextAreaElement>) => {
    if (event.key === 'Enter' && event.ctrlKey) {
      event.preventDefault();
      handleSubmit(onSubmit)();
      reset();
    }
  }

  return (
    <>
      {hasMessages(errors) && <ErrorList errors={errors} />}

      <form
        data-testid="comment-form"
        className="card comment-form"
        onSubmit={handleSubmit(onSubmit)}
      >
        <div className="card-block">
          <fieldset>
            <textarea
              className="form-control"
              placeholder="Write a comment..."
              rows={3}
              {...register('body')}
              onKeyDown={handleKeyDown}
            />
          </fieldset>
        </div>
        <div className="card-footer">
          <img
            src={session.image}
            className="comment-author-img"
            alt={session.username}
          />

          <button
            className="btn btn-sm btn-primary"
            type="submit"
            disabled={!canSubmit}
          >
            Post Comment
          </button>
        </div>
      </form>
    </>
  )
})
