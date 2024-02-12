"use client";
import { IntersectorProvider } from "@/context/interSectorContext";

export const WrapContextComponent = ({
  children,
}: {
  children: React.ReactNode;
}) => {
  return (
    <div>
      <IntersectorProvider>{children}</IntersectorProvider>
    </div>
  );
};
