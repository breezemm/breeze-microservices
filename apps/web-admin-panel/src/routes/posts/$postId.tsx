import React from 'react'
import {createFileRoute} from '@tanstack/react-router'

export const Route = createFileRoute('/posts/$postId')({
  component: PostComponent,
})


function PostComponent() {
  const {postId} = Route.useParams()

  return (
    <>
      <h1>Post {postId}</h1>
      <p>Post content</p>
    </>
  )
}
