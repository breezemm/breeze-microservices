import React from "react";
import { allPosts, Post } from "contentlayer/generated";
import MdxComponent from "@/components/MdxComponent";
import TermsClientWrapper from "@/app/components/TermsClientWrapper";

export async function generateStaticParams() {
  return allPosts.map((post) => ({
    slug: post._raw.flattenedPath,
  }));
}

export default async function Terms({ params }: { params: { slug: string } }) {
  const post = allPosts.find((post) => post._raw.flattenedPath === params.slug);

  return (
    <div>
      <TermsClientWrapper>
        {post && <MdxComponent code={post.body.code} />}
      </TermsClientWrapper>
    </div>
  );
}
