import { createFileRoute } from '@tanstack/react-router';
import { Badge } from '../../../../packages/ui/src/badge';

export const Route = createFileRoute('/')({
    component: () => (
      <div>
        <div style={{ marginBottom: '20px' }}>
          <div>Hello /!</div>
        </div>
        <div style={{ marginBottom: '20px' }}>
          <Badge>Badge</Badge>
        </div>
        {/* Add new sections for other components here */}
        <div style={{ marginBottom: '20px' }}>
          {/* Another Component */}
        </div>
      </div>
    ),
  });