import { createFileRoute } from '@tanstack/react-router';
import { Badge } from '../../../../packages/ui/src/badge';
import { Calendar } from '../../../../packages/ui/src/calendar';
// import { Carousel } from '../../../../packages/ui/src/carousel';
import { Card, CardContent } from '@breeze/ui';
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselNext,
  CarouselPrevious,
} from "../../../../packages/ui/src/carousel"

import { Checkbox } from '../../../../packages/ui/src/checkbox';
import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from '../../../../packages/ui/src/collapsible';



export const Route = createFileRoute('/')({

  component: () => (

    <div>
      <div style={{ marginBottom: '20px' }}>
        <h1>Hello</h1>
        <div>Hello /!</div>
      </div>
      <div style={{ marginBottom: '20px' }}>
        <h1>Badge</h1>

        <Badge>Badge</Badge>
      </div>
      {/* Add new sections for other components here */}
      <div style={{ marginBottom: '20px' }}>
        <h1>Calendar</h1>

        <Calendar />
      </div>
      <div style={{ marginBottom: '20px' }}>
        <h1>Carousel</h1>
        <Carousel className="w-full max-w-xs">
          <CarouselContent>
            {Array.from({ length: 5 }).map((_, index) => (
              <CarouselItem key={index}>
                <div className="p-1">
                  <Card>
                    <CardContent className="flex aspect-square items-center justify-center p-6">
                      <span className="text-4xl font-semibold">{index + 1}</span>
                    </CardContent>
                  </Card>
                </div>
              </CarouselItem>
            ))}
          </CarouselContent>
          <CarouselPrevious />
          <CarouselNext />
        </Carousel>


      </div>
      <div style={{ marginBottom: '20px' }}>
        <h1>Checkbox</h1>

        <Checkbox>Checkbox</Checkbox>
      </div>
      <div style={{ marginBottom: '20px' }}>
        <h1>Collapsible</h1>

        <Collapsible>
          <CollapsibleTrigger>Can I use this in my project?</CollapsibleTrigger>
          <CollapsibleContent>
            Yes. Free to use for personal and commercial projects. No attribution
            required.
          </CollapsibleContent>
        </Collapsible>
      </div>
    </div>
  ),
});