import { getRandomNumber } from '~6shared/lib/math'
import { Skeleton } from '~6shared/ui/skeleton'
import { Stack } from '~6shared/ui/stack'

export function TagFilterSkeleton() {
  return (
    <Stack spacing={4}>
      {new Array(getRandomNumber({ min: 10, max: 15 }))
        .fill(0)
        .map((_, idx) => (
          <Skeleton
            // eslint-disable-next-line react/no-array-index-key
            key={idx}
            variant="rounded"
            width={getRandomNumber({ min: 30, max: 90 })}
          />
        ))}
    </Stack>
  )
}
